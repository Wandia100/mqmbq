<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistoriesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="winning-histories-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prize_id') ?>

    <?= $form->field($model, 'station_show_prize_id') ?>

    <?= $form->field($model, 'reference_name') ?>

    <?= $form->field($model, 'reference_phone') ?>

    <?php // echo $form->field($model, 'reference_code') ?>

    <?php // echo $form->field($model, 'station_id') ?>

    <?php // echo $form->field($model, 'presenter_id') ?>

    <?php // echo $form->field($model, 'station_show_id') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'transaction_cost') ?>

    <?php // echo $form->field($model, 'conversation_id') ?>

    <?php // echo $form->field($model, 'transaction_reference') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'remember_token') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
