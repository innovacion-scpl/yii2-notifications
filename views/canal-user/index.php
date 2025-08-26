<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use webzop\notifications\model\CanalUser;
use webzop\notifications\model\TipoNotificacionCanal;
use backend\assets\AppAsset;
use webzop\notifications\AdminAsset;

AdminAsset::register($this);
AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CentroCostoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis notificaciones';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget(['overrideYiiConfirm' => true]);

?>
<div class="mis-notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'subject',
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'attribute' => 'check_notify_email',
                'content'=> function($model) use($modelCanalEmail, $user_id){
                    /** buscar la asociación de canal y notificación */
                    $notificacionCanal = CanalUser::buscarPorUsuario($modelCanalEmail->id, $model->id, $user_id);
                    $tipoNotCanal = TipoNotificacionCanal::buscar($modelCanalEmail->id, $model->id);
                   
                    if (isset($tipoNotCanal->es_seleccionable) && ($tipoNotCanal->es_seleccionable == 1)) {
                        $info =  Html::tag('span',
                                            '<i class="fas fa-info-circle"></i>',
                                            [
                                                'class' => 'ps-2',
                                                'style' => 'color:#3584e4',
                                                'data-bs-toggle' => 'tooltip',
                                                'title' => 'La notificación es obligatoria.',
                                                'data-bs-html' => 'true'
                                            ]
                                        );                      
                        $disabled = true;
                    }else{
                        $disabled = false;
                        $info = "";
                    }
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalEmail->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                            'disabled' => $disabled
                        ]
                    ).$info; 
                },
                'header' => 'Notificar vía Email',
                'rowHighlight' => false
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'attribute' => 'check_notify_system',
                'content'=> function($model) use($modelCanalSystem, $user_id){
                    /** buscar la asociación de canal y notificación */
                    $notificacionCanal = CanalUser::buscarPorUsuario($modelCanalSystem->id, $model->id, $user_id);
                    $tipoNotCanal = TipoNotificacionCanal::buscar($modelCanalSystem->id, $model->id);

                    if (isset($tipoNotCanal->es_seleccionable) && ($tipoNotCanal->es_seleccionable == 1)) {
                        $info =  Html::tag('span',
                                            '<i class="fas fa-info-circle"></i>',
                                            [
                                                'class' => 'ps-2',
                                                'style' => 'color:#3584e4',
                                                'data-bs-toggle' => 'tooltip',
                                                'title' => 'La notificación es obligatoria.',
                                                'data-bs-html' => 'true'
                                            ]
                                        );                      
                        $disabled = true;
                    }else{
                        $disabled = false;
                        $info = "";
                    }
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalSystem->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                            'disabled' => $disabled

                        ]
                    ).$info; 
                },
                'header' => 'Notificar por sistema',
                'rowHighlight' => false
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
