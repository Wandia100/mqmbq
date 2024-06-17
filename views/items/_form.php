<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'item_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reorder_level')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receiving_quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'allow_alt_description')->textInput() ?>

    <?= $form->field($model, 'is_serialized')->textInput() ?>

    <?= $form->field($model, 'stock_type')->textInput() ?>

    <?= $form->field($model, 'item_type')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'custom1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom6')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom8')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom9')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom10')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
