<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CanalNotificacion */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="canal-notificacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body w-25">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        
            <div class="form-group">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
