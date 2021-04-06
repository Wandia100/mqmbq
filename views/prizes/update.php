<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Prizes */

$this->title = 'Update Prizes: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Prizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prizes-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
