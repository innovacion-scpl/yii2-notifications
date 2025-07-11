<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoNotificacion */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="tipo-notificacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body w-50">
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label('Asunto') ?>
            <?= $form->field($model, 'content')->textInput(['maxlength' => true])->label('Contenido') ?>
        
            <div class="form-group">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
