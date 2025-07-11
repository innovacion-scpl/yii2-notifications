<?php

namespace webzop\notifications\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use webzop\notifications\model\TipoNotificacion;
use webzop\notifications\model\TipoNotificacionSearch;

class TipoNotificacionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new TipoNotificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate(){
        $model = new TipoNotificacion();

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
     * Deletes an existing TipoNotificacion model.
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

     /**
     * Finds the TipoNotificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TipoNotificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoNotificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe');
    }
}
