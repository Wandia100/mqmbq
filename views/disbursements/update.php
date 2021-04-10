<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursements */

$this->title = 'Update Disbursements: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursements-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
