<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursements-form">

    <?php $form = ActiveForm::begin(); ?>
    
    

    <?= $form->field($model, 'disbursement_type')->dropDownList(['presenter_commission'=>'Presenter Commission','management_commission'=>'Management Commission','winning'=>'Winning','refund'=>'Refund','expenses'=>'Expenses'], ['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'reference_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
