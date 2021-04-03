<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="winning-histories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prize_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_show_prize_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presenter_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_show_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'transaction_cost')->textInput() ?>

    <?= $form->field($model, 'conversation_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transaction_reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'remember_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
