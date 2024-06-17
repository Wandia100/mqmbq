<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPresenters */

$this->title = 'Update Station Show Presenters: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Station Show Presenters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="station-show-presenters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
