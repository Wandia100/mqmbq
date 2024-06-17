<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-shows-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'station_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'show_code') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'management_commission') ?>

    <?php // echo $form->field($model, 'price_amount') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'draw_count') ?>

    <?php // echo $form->field($model, 'invalid_percentage') ?>

    <?php // echo $form->field($model, 'monday') ?>

    <?php // echo $form->field($model, 'tuesday') ?>

    <?php // echo $form->field($model, 'wednesday') ?>

    <?php // echo $form->field($model, 'thursday') ?>

    <?php // echo $form->field($model, 'friday') ?>

    <?php // echo $form->field($model, 'saturday') ?>

    <?php // echo $form->field($model, 'sunday') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
