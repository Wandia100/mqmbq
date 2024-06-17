<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationManagementStations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-management-stations-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'station_id')->dropDownList(\app\models\Stations::getStations(),['prompt' => '--Select--']) ?>
    <?= $form->field($model, 'station_management_id')->dropDownList(\app\models\Users::getUsersList(5),['prompt' => '--Select--']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
