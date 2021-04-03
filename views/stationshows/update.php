<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */

$this->title = 'Update Station Shows: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Station Shows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="station-shows-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
