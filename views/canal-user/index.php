<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use webzop\notifications\model\CanalUser;

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
                'content'=> function($model) use($modelCanalEmail){
                    /** buscar la asociación de canal y notificación */
                    $notificacionCanal = CanalUser::buscar($modelCanalEmail->id, $model->id);
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalEmail->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                        ]
                    ); 
                },
                'header' => 'Asignar notificación',
                'rowHighlight' => false
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'attribute' => 'check_notify_system',
                'content'=> function($model) use($modelCanalSystem){
                    /** buscar la asociación de canal y notificación */
                    $notificacionCanal = CanalUser::buscar($modelCanalSystem->id, $model->id);
                    return html::checkbox('check_notify',false,[
                            'value' => $model->id,
                            'checked' => !empty($notificacionCanal) ? true : false,
                            'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanalSystem->id.', '.$model->id.', "notifications/canal-user/add")',
                            'class' => 'check',
                        ]
                    ); 
                },
                'header' => 'Asignar notificación',
                'rowHighlight' => false
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
