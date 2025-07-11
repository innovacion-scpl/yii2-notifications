<?php

namespace backend\controllers;

use webzop\notifications\model\CanalNotificacionSearch;
use Yii;

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

}
