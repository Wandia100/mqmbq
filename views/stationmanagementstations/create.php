<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationManagementStations */

$this->title = 'Create Station Management Stations';
$this->params['breadcrumbs'][] = ['label' => 'Station Management Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-management-stations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
