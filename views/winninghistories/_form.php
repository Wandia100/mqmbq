<?php

use app\models\StationShows;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="winning-histories-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'prize_id')->dropDownList(\app\models\Prizes::getPrizesList(),['prompt' => '--Select--']) ?>
    <?= $form->field($model, 'station_id')->dropDownList(\app\models\Stations::getStations(),['prompt' => '--Select--']) ?>
    <?= $form->field($model, 'presenter_id')->dropDownList(\app\models\Users::getUsersList(3),['prompt' => '--Select--']) ?>
    <?= $form->field($model, 'station_show_id')->dropDownList(StationShows::getStationShows(),['prompt' => '--Select--']) ?>
    <?= $form->field($model, 'reference_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'reference_phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'transaction_reference')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'created_at')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
