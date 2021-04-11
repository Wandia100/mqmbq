<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPrizes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-show-prizes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_show_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prize_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'draw_count')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <?= $form->field($model, 'monday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tuesday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wednesday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thursday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'friday')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
