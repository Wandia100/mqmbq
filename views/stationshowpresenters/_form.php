<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPresenters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-show-presenters-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_show_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presenter_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_admin')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
