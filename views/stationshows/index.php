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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'station_id',
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
            //'enabled',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>


</div>
