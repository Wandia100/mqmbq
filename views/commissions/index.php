<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commissions-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => ['t' => isset($_GET['t']) ?$_GET['t'] :'p'],
                                'url'  => '/commissions/index',
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

            //'id',
           # 'user_id',
            [
                'attribute' => 'user',
                'value'     => 'fullname'
            ],
            #'station_id',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            #'station_show_id',
            [
                'attribute' => 'stationshowname',
                'value'     => 'stationshows.name'
            ],
            'amount',
            'transaction_cost',
            'transaction_reference',
            'status',
            'created_at',
            //'updated_at',
            //'deleted_at',

        ],
    ]); ?>


</div>
