<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\dialog\Dialog;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CentroCostoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Canales de notificación';
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget(['overrideYiiConfirm' => true]);

?>
<div class="canal-notificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cargar nuevo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {asociate-notify}',
                'buttons' => [
                    'asociate-notify' => function($url,$model){
                        return Html::a('<span class="fas fa-mail-bulk"></span>', $url);  
                    }
                ]
            ],
        ],
    ]); ?>

</div>
