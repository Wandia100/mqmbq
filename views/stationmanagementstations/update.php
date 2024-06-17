<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationManagementStations */

$this->title = 'Update Station Management Stations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Station Management Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="station-management-stations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
