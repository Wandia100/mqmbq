<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-shows-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'show_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'commission')->textInput() ?>

    <?= $form->field($model, 'management_commission')->textInput() ?>

    <?= $form->field($model, 'price_amount')->textInput() ?>

    <?= $form->field($model, 'target')->textInput() ?>

    <?= $form->field($model, 'draw_count')->textInput() ?>

    <?= $form->field($model, 'invalid_percentage')->textInput() ?>

    <?= $form->field($model, 'monday')->textInput() ?>

    <?= $form->field($model, 'tuesday')->textInput() ?>

    <?= $form->field($model, 'wednesday')->textInput() ?>

    <?= $form->field($model, 'thursday')->textInput() ?>

    <?= $form->field($model, 'friday')->textInput() ?>

    <?= $form->field($model, 'saturday')->textInput() ?>

    <?= $form->field($model, 'sunday')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
