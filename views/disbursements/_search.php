<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DisbursementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disbursements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reference_id') ?>

    <?= $form->field($model, 'reference_name') ?>

    <?= $form->field($model, 'phone_number') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'conversation_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'disbursement_type') ?>

    <?php // echo $form->field($model, 'transaction_reference') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
