<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationTarget */

$this->title = 'Update Station Target: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Station Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="station-target-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
