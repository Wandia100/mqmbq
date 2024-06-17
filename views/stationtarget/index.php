<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationTargetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Station Targets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-target-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Station Target', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'start_time',
            'end_time',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            'target',
            'station_id',
            //'unique_field',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
