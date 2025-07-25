<?php

namespace webzop\notifications\controllers;

use common\models\User;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use webzop\notifications\model\TipoNotificacion;
use webzop\notifications\model\CanalNotificacion;
use webzop\notifications\model\TipoNotificacionSearch;
use webzop\notifications\model\CanalNotificacionSearch;
use webzop\notifications\model\CanalUser;
use webzop\notifications\model\TipoNotificacionCanal;
use yii\helpers\VarDumper;

class CanalNotificacionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new CanalNotificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate(){
        $model = new CanalNotificacion();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Canal de notificación creado correctamente');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error', 'Ocurrió un error al crear el canal de notificación');
            }
        }
        return $this->render('create',
        [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id){
        $model = $this::findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Canal de notificación modificado correctamente');
                return $this->redirect(['index']);
            }else{
                Yii::$app->session->setFlash('error', 'Ocurrió un error al modificar el canal de notificación');
            }
        }
        return $this->render('update',
        [
            'model' => $model,
        ]);
    }

     /**
     * Deletes an existing CanalNotificacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAsociateNotify($id){
        $model = $this->findModel($id);
        /** Debo buscar todas las notificaciones, más las que ya estén asociadas */

        // $notificaciones = ArrayHelper::map(TipoNotificacion::searchAll(), 'id', 'subject');
        $searchModelTipoNotificaciones = new TipoNotificacionSearch();
        $dataProviderTipoNotificaciones = $searchModelTipoNotificaciones->search(Yii::$app->request->queryParams);

        return $this->render('asociar-notificaciones', [
            'modelCanal' => $model,
            'searchModelTipoNotificaciones' => $searchModelTipoNotificaciones,
            'dataProviderTipoNotificaciones' => $dataProviderTipoNotificaciones
        ]);
    }

    public function actionAsociarNotificacion(){
        $id_canal = Yii::$app->request->post('id_canal');
        $id_notificacion = Yii::$app->request->post('id_notificacion');
        $checked = Yii::$app->request->post('check');
        $tipoNotificacionCanal = TipoNotificacionCanal::buscar($id_canal, $id_notificacion);
        try {
            if (isset($tipoNotificacionCanal->id_tipo_notificacion) && $checked) {
                // eliminar asociación, se deberá eliminar de todos los usuarios que lo tienen asignado
                $cambioEfectuado = TipoNotificacionCanal::eliminar($id_canal, $id_notificacion);
            }else{
                // agregar asociación
                $model = new TipoNotificacionCanal();
                $model->id_canal = $id_canal;
                $model->id_tipo_notificacion = $id_notificacion;
                $cambioEfectuado = $model->save();
                Yii::error(VarDumper::dumpAsString($cambioEfectuado));
            }
            return $cambioEfectuado;           
        } catch (Exception $e) {
            Yii::error(VarDumper::dumpAsString($e));
            return false;
        }
    }

    public function actionMarcarEsSeleccionable(){
        $id_canal = Yii::$app->request->post('id_canal');
        $id_notificacion = Yii::$app->request->post('id_notificacion');
        $checked = Yii::$app->request->post('check');
        $tipoNotificacionCanal = TipoNotificacionCanal::buscar($id_canal, $id_notificacion);
        try {
            if (($tipoNotificacionCanal->es_seleccionable == 1) && $checked) {
                $tipoNotificacionCanal->es_seleccionable = 0;
                $cambioEfectuado = $tipoNotificacionCanal->save();
                /** buscar todos los usuarios y quitarle la asociación */
            }else{
                $tipoNotificacionCanal->es_seleccionable = 1;
                $cambioEfectuado = $tipoNotificacionCanal->save();
                /** buscar todos los usuarios y agregarles esta asociación */
                $id_users = ArrayHelper::map(User::findAllActive(), 'id', 'id');
                $canal_user_model = new CanalUser();
                foreach ($id_users as $index => $id) {
                    if (!$canal_user_model->guardar($id, $id_canal, $id_notificacion)) {
                        throw new Exception("Error al asociar la notificación al usuario");                        
                    }
                }
            }
            return $cambioEfectuado;           
        } catch (Exception $e) {
            return false;
        }
    }


     /**
     * Finds the CanalNotificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CanalNotificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CanalNotificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe');
    }
}
