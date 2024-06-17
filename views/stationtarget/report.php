<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationTargetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'STATION TARGETS REPORT';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-target-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/stationtarget/report',
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

            //'id',
            'station_name',
            'range_date',
            'start_time',
            'end_time',
            'target',
            'achieved',
            'diff',
            'target',
            //'station_id',
            //'unique_field',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
