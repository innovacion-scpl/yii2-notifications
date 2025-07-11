<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webzop\models\CanalNotificacion */

$this->title = 'Cargar nuevo canal de notificación';
$this->params['breadcrumbs'][] = ['label' => 'Canales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="canal-notifications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
