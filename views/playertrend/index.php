<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlayerTrendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'PLAYER TRENDS REPORT';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-trend-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/playertrend/index',
                                'from' => date( 'Y-m-d', strtotime( '-14 days' ) )
                        ])?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>

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
