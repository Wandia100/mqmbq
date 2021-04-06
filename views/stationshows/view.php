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


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       
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
