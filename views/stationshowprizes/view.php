<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StationShowPrizes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Station Show Prizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="station-show-prizes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'station_id',
            'station_show_id',
            'prize_id',
            'draw_count',
            'amount',
            'enabled',
            'created_at',
            'updated_at',
            'deleted_at',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
        ],
    ]) ?>

</div>
