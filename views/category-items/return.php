<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Return';
?>

<div class="category-items-return">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($returned, 'category_item_id')->hiddenInput()->label(false) ?>
    <?= $form->field($returned, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($returned, 'outprice')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?= $form->field($returned, 'howmany')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
