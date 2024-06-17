<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPresenters */

$this->title = 'Create Station Show Presenters';
$this->params['breadcrumbs'][] = ['label' => 'Station Show Presenters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-show-presenters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
