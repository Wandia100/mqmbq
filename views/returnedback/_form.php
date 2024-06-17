<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReturnedBack */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="returned-back-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_item_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'howmany')->textInput() ?>

    <?= $form->field($model, 'outprice')->textInput() ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
