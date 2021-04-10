<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WinningHistoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Winning Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winning-histories-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/winninghistories/index',
                                'from' => date( 'Y-m-d', strtotime( '-42 days' ) )
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

           // 'id',
           # 'prize_id',
            [
                'attribute' => 'prizename',
                'value'     => 'prizes.name'
            ],
            #'station_show_prize_id',
            [
                'attribute' => 'stationshowprizeamount',
                'value'     => 'stationshowprize.amount'
            ],
            'reference_name',
            'reference_phone',
            //'reference_code',
            #'station_id',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            #'presenter_id',
            [
                'attribute' => 'presenter',
                'value'     => 'fullname'
            ],
            #'station_show_id',
            [
                'attribute' => 'stationshowname',
                'value'     => 'stationshows.name'
            ],
            'amount',
            'transaction_cost',
            //'conversation_id',
            //'transaction_reference',
            'status',
            //'remember_token',
            'created_at',
            //'updated_at',
            //'deleted_at',

        ],
    ]); ?>


</div>
