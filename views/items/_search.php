<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'item_number') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'cost_price') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'reorder_level') ?>

    <?php // echo $form->field($model, 'receiving_quantity') ?>

    <?php // echo $form->field($model, 'item_id') ?>

    <?php // echo $form->field($model, 'pic_filename') ?>

    <?php // echo $form->field($model, 'allow_alt_description') ?>

    <?php // echo $form->field($model, 'is_serialized') ?>

    <?php // echo $form->field($model, 'stock_type') ?>

    <?php // echo $form->field($model, 'item_type') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'custom1') ?>

    <?php // echo $form->field($model, 'custom2') ?>

    <?php // echo $form->field($model, 'custom3') ?>

    <?php // echo $form->field($model, 'custom4') ?>

    <?php // echo $form->field($model, 'custom5') ?>

    <?php // echo $form->field($model, 'custom6') ?>

    <?php // echo $form->field($model, 'custom7') ?>

    <?php // echo $form->field($model, 'custom8') ?>

    <?php // echo $form->field($model, 'custom9') ?>

    <?php // echo $form->field($model, 'custom10') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
