<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Station Shows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="station-shows-view">

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
            'name',
            'description:ntext',
            'show_code',
            'amount',
            'commission',
            'management_commission',
            'price_amount',
            'target',
            'draw_count',
            'invalid_percentage',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
            'start_time',
            'end_time',
            'enabled',
            'created_at',
            'updated_at',
            'deleted_at',
        ],
    ]) ?>

</div>
