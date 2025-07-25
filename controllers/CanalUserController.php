<?php

namespace webzop\notifications\controllers;

use Yii;
use Exception;
use webzop\notifications\model\CanalUser;
use webzop\notifications\model\CanalNotificacion;
use webzop\notifications\model\TipoNotificacionCanal;
use webzop\notifications\model\TipoNotificacionSearch;
use yii\helpers\VarDumper;

class CanalUserController extends \yii\web\Controller
{
    public function actionIndex($id = null){
        $searchModel = new TipoNotificacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        $modelCanalEmail = CanalNotificacion::buscar(CanalNotificacion::ID_CANAL_EMAIL);
        $modelCanalSystem  = CanalNotificacion::buscar(CanalNotificacion::ID_CANAL_SISTEMA);

        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelCanalEmail' => $modelCanalEmail,
            'modelCanalSystem' => $modelCanalSystem,
            'user_id' => isset($id) ? $id : Yii::$app->user->identity->id
        ]);
    }

    public function actionAdd(){
        $id_canal = Yii::$app->request->post('id_canal');
        $id_notificacion = Yii::$app->request->post('id_notificacion');
        $checked = Yii::$app->request->post('check');
            $id_user = Yii::$app->user->identity->id;

        $canalUserNotificacion = CanalUser::buscarPorUsuario($id_canal, $id_notificacion, $id_user);
        try {
            if (isset($canalUserNotificacion->id_tipo_notificacion) && $checked == 'false') {
                // eliminar asociación
                $cambioEfectuado = CanalUser::eliminar($id_canal, $id_notificacion, $id_user);
            }else{
                // agregar asociación
                $model = new CanalUser();
                $model->id_canal = $id_canal;
                $model->id_tipo_notificacion = $id_notificacion;
                $model->id_user = $id_user;
                $cambioEfectuado = $model->save();
            }
            if (!$cambioEfectuado) {
                throw new Exception("No se pudo efectuar el cambio.");
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
