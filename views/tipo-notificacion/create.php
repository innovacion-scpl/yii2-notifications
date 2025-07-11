<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model webzop\models\TipoNotificacion */

$this->title = 'Cargar nuevo tipo de notificación';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de notificaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-notifications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
