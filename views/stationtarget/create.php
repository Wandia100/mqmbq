<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationTarget */

$this->title = 'Create Station Target';
$this->params['breadcrumbs'][] = ['label' => 'Station Targets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-target-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
