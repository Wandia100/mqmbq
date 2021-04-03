<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HourlyPerformanceReports */

$this->title = 'Update Hourly Performance Reports: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hourly Performance Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hourly-performance-reports-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
