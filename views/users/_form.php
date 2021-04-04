<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'national_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')->textInput() ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perm_group')->dropDownList(\app\models\PermissionGroup::getPermissionGroup(),['prompt'=>'--Select--']) ?>


    <?php
        if($model -> isNewRecord)
            echo $form->field($model, 'password')->passwordInput(['maxlength' => true]) 
    ?>

    <?= $form->field($model, 'enabled')->dropDownList(['1'=>'Yes','0'=>'No'],['prompt'=>'--Select--']) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
