<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SiteReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'report_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report_value')->textInput() ?>

    <?= $form->field($model, 'report_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
