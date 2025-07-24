<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use webzop\notifications\model\CanalUser;
use webzop\notifications\model\TipoNotificacionCanal;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CentroCostoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de notificación';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget(['overrideYiiConfirm' => true]);

?>
<div class="tipo-notificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cargar nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalEmail->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                            'disabled' => isset($tipoNotCanal->es_seleccionable) ? true : false
                        ]
                    ); 
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
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalSystem->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                            'disabled' => isset($tipoNotCanal->es_seleccionable) ? true : false

                        ]
                    ); 
                },
                'header' => 'Notificar por sistema',
                'rowHighlight' => false
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
