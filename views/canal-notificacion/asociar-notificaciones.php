<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use webzop\notifications\AdminAsset;
use webzop\notifications\model\TipoNotificacionCanal;

AdminAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CentroCostoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asociar notificaciones al canal: '.$modelCanal->nombre;
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget(['overrideYiiConfirm' => true]);

?>
<div class="canal-notificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cargar nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid']); ?>

        <?= GridView::widget([
                'dataProvider' => $dataProviderTipoNotificaciones,
                'filterModel' => $searchModelTipoNotificaciones,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'subject',
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        'attribute' => 'check_notify',
                        'content'=> function($model) use($modelCanal){
                            /** buscar la asociación de canal y notificación */
                            $notificacionCanal = TipoNotificacionCanal::buscar($modelCanal->id, $model->id);
                            return html::checkbox('check_notify',false,[
                                    'value' => $model->id,
                                    'checked' => !empty($notificacionCanal) ? true : false,
                                    'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanal->id.', '.$model->id.', "notifications/canal-notificacion/asociar-notificacion")',
                                    'class' => 'check',
                                ]
                            ); 
                        },
                        'header' => 'Asignar notificación',
                        'rowHighlight' => false
                    ],
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        'attribute' => 'check_es_seleccionable',
                        'content'=> function($model) use($modelCanal){
                            /** buscar la asociación de canal y notificación */
                            $notificacionCanal = TipoNotificacionCanal::buscar($modelCanal->id, $model->id);
                            if (!empty($notificacionCanal) && $notificacionCanal->es_seleccionable ) {
                                $check = true;
                            }else{
                                $check = false;
                            }

                            return html::checkbox('check_es_seleccionable',false,[
                                    'value' => $model->id,
                                    'checked' => $check,
                                    'disabled' => empty($notificacionCanal),
                                    'onclick'=> 'checkAsociarAusentismo(this, '.$modelCanal->id.', '.$model->id.', "notifications/canal-notificacion/marcar-es-seleccionable")',
                                    'class' => 'check',
                                ]
                            ); 
                        },
                        'header' => 'Es seleccionable',
                        'rowHighlight' => false
                    ],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'template' => '{update} {delete} {asociate-notify}',
                    //     'buttons' => [
                    //         'asociate-notify' => function($url,$model){
                    //             return Html::a('<span class="fas fa-mail-bulk"></span>', $url);  
                    //         }
                    //     ]
                    // ],
                ],
            ]); 
        ?>
    <?php  Pjax::end(); ?>
</div>
