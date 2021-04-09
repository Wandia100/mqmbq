<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SmsCategory */

$this->title = 'Update Sms Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sms Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sms-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
