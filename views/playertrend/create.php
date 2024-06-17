<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlayerTrend */

$this->title = 'Create Player Trend';
$this->params['breadcrumbs'][] = ['label' => 'Player Trends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-trend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
