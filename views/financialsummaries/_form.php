<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FinancialSummaries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="financial-summaries-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mpesa_today')->textInput() ?>

    <?= $form->field($model, 'mpesa_total')->textInput() ?>

    <?= $form->field($model, 'transaction_history_today')->textInput() ?>

    <?= $form->field($model, 'transaction_history_total')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
