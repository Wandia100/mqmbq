<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationShowsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Station Shows';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-shows-index">

    <p>
        <?= Html::a('Create Station Shows', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=> \kartik\grid\GridView::TARGET_BLANK
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'station_id',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            'name',    
           // 'description:ntext',
            'show_code',
            //'amount',
            //'commission',
            //'management_commission',
            //'price_amount',
            //'target',
            //'draw_count',
            //'invalid_percentage',
            //'monday',
            //'tuesday',
            //'wednesday',
            //'thursday',
            //'friday',
            //'saturday',
            //'sunday',
            'start_time',
            'end_time',
            'jackpot',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            //['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
    'toolbar' => [
        '{toggleData}',
                '{export}',
    ],
        'panel'=>[
            'type'=>'default',
           // 'heading'=>'Users'
        ]
    ]); ?>


</div>
