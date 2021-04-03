<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationManagementStationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Station Management Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-management-stations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Station Management Stations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'station_id',
            'station_management_id',
            'created_at',
            'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
