<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionHistories */

$this->title = 'Update Transaction Histories: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transaction Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-histories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
