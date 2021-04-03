<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPrizes */

$this->title = 'Create Station Show Prizes';
$this->params['breadcrumbs'][] = ['label' => 'Station Show Prizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-show-prizes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
