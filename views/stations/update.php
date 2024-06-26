<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stations */

$this->title = 'Update Stations: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stations-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
