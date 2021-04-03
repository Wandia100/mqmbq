<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HourlyPerformanceReports */

$this->title = 'Create Hourly Performance Reports';
$this->params['breadcrumbs'][] = ['label' => 'Hourly Performance Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hourly-performance-reports-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
