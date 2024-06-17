<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationTarget */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-target-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'station_id')->dropDownList(\app\models\Stations::getStations(),['prompt' => '--Select--']) ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>


    <?= $form->field($model, 'target')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
