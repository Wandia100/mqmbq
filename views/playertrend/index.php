<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlayerTrendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Player Trends';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-trend-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Player Trend', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'msisdn',
            'hour',
            'station_id',
            'station',
            //'frequency',
            //'hour_date',
            //'unique_field',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
