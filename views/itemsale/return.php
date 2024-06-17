<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Return';
?>

<div class="itemsale-return">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_item_id')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'outprice')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'howmany')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-block btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
