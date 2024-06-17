<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-items-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'category_id')->textInput(['maxlength' => true]) ->dropDownList(\app\models\Categories::getCategories(),['prompt' => '--Select--']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'generate_barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inprice')->textInput() ?>

    <?= $form->field($model, 'outprice')->textInput(['id' => 'outprice'])?>

    <?= $form->field($model, 'quantity')->textInput(['id' => 'quantity'])?>

    <?= $form->field($model, 'target')->textInput(['id' => 'target', 'readonly' => true]) ?>

    <?= $form->field($model, 'enabled')->dropDownList([0 => 'Disabled', 1 => 'Enabled']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    document.getElementById('outprice').addEventListener('input', updateTarget);
    document.getElementById('quantity').addEventListener('input', updateTarget);

    function updateTarget() {
        var outprice = parseFloat(document.getElementById('outprice').value) || 0;
        var quantity = parseFloat(document.getElementById('quantity').value) || 0;
        var target = outprice * quantity;
        document.getElementById('target').value = target.toFixed(2);
    }
</script>
