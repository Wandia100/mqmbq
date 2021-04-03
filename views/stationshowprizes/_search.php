<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPrizesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-show-prizes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'station_id') ?>

    <?= $form->field($model, 'station_show_id') ?>

    <?= $form->field($model, 'prize_id') ?>

    <?= $form->field($model, 'draw_count') ?>

    <?php // echo $form->field($model, 'amount') ?>

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
