<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HourlyPerformanceReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hourly Performance Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hourly-performance-reports-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Hourly Performance Reports', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'station_id',
            'hour',
            'amount',
            'invalid_codes',
            //'total_amount',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
