<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationShowPrizesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Station Show Prizes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-show-prizes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Station Show Prizes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'station_id',
            'station_show_id',
            'draw_count',
            //'amount',
            //'enabled',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            //'monday',
            //'tuesday',
            //'wednesday',
            //'thursday',
            //'friday',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
