<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HourlyPerformanceReports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hourly-performance-reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'invalid_codes')->textInput() ?>

    <?= $form->field($model, 'total_amount')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
