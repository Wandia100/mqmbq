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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Winning Histories', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prize_id',
            'station_show_prize_id',
            'reference_name',
            'reference_phone',
            //'reference_code',
            //'station_id',
            //'presenter_id',
            //'station_show_id',
            //'amount',
            //'transaction_cost',
            //'conversation_id',
            //'transaction_reference',
            //'status',
            //'remember_token',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
