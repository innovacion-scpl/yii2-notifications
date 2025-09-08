<?php

use yii\helpers\Html;
use kartik\editors\Summernote;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoNotificacion */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="tipo-notificacion-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label('Asunto') ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'view')->textInput(['maxlength' => true, 'value' => $model->isNewRecord ? 'notificacion' : $model->view])->label('Vista') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?= $form->field($model, 'content')->widget(Summernote::class, [
                        'useKrajeePresets' => true,
                        // other widget settings
                    ]);?>
                </div>
            </div>
        
        
            <div class="form-group">
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
