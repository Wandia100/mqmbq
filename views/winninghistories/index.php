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

    <?=  kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=> \kartik\grid\GridView::TARGET_BLANK
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'toolbar' => [
            '{toggleData}',
                    '{export}',
        ],
        'panel'=>[
            'type'=>'primary',
            'heading'=>'transactionhistories'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           # 'prize_id',
            [
                'attribute' => 'prizename',
                'value'     => 'prizes.name'
            ],
            #'station_show_prize_id',
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
            //'transaction_cost',
            'transaction_reference',
            //'conversation_id',
            //'transaction_reference',
            'status',
            //'remember_token',
            'created_at',
            //'updated_at',
            //'deleted_at',

        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'toolbar' => [
            '{toggleData}',
                    '{export}',
        ],
        'panel'=>[
            'type'=>'default',
            'heading'=>'winners histories'
        ]
    ]); ?>


</div>
