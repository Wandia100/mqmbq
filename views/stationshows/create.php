<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */

$this->title = 'Create Station Shows';
$this->params['breadcrumbs'][] = ['label' => 'Station Shows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-shows-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
