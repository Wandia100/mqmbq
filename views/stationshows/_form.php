<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-shows-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'station_id')->dropDownList(\app\models\Stations::getStations(),['prompt' => '--Select--']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'show_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'target')->textInput() ?>

    <?= $form->field($model, 'monday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'tuesday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'wednesday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--'])?>

    <?= $form->field($model, 'thursday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'friday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--'])?>

    <?= $form->field($model, 'saturday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'sunday')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'start_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>
    <?= $form->field($model, 'jackpot')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
