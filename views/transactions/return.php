<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>

<?= $form->field($model, 'quantity')->textInput(['maxlength' => true, 'readonly' => true]) ?>

<?= $form->field($model, 'created_at')->textInput(['maxlength' => true, 'readonly' => true]) ?>

<?= $form->field($model, 'quantityToReturn')->textInput(['type' => 'number']) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
