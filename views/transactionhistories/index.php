<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionHistoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaction Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-histories-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->renderFile('@app/views/layouts/partials/_datetime_filter_.php', [
                        'data' => [],
                        'url'  => '/transactionhistories/index',
                        'from' => date( 'Y-m-d H:i', strtotime( '-5 hours' ) )
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

           // 'id',Mpesadetails
           # 'mpesa_payment_id',
            'mpesadetails',
            'reference_name',
            'reference_phone',
            'reference_code',
            #'station_id',
            #'station_show_id',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            [
                'attribute' => 'stationshowname',
                'value'     => 'stationshows.name'
            ],
            'amount',
            'commission',
            //'status',
            //'is_archived',
            'created_at',
            //'updated_at',
            //'deleted_at',

        ],
    ]); ?>


</div>
