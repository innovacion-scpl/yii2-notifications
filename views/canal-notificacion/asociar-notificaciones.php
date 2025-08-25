<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use webzop\notifications\AdminAsset;
use webzop\notifications\model\TipoNotificacionCanal;
use yii\helpers\VarDumper;

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

    <div class="alert alert-info" role="alert">
        Al seleccionar  la opción de <b>inhabilitar para usuarios</b> usted le esta asignando la notificación a todos los agentes y no podrán deshabilitarse
        dicha notificación.
    </div>

    <?php Pjax::begin(['id' => 'pjax-grid']); ?>

        <?= GridView::widget([
                'dataProvider' => $dataProviderTipoNotificaciones,
                'filterModel' => $searchModelTipoNotificaciones,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [   'label' => 'Asunto',
                        'attribute' => 'subject',
                    ],
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
                        'header' => 'Inhabilitar para usuarios',
                        'rowHighlight' => false
                    ],
                ],
            ]); 
        ?>
    <?php  Pjax::end(); ?>
</div>
