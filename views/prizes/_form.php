<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prizes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prizes-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'mpesa_disbursement')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'enabled')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--'])?>
    <?= $form->field($model, 'enable_tax')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--'])?>
    <?= $form->field($model, 'tax')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
