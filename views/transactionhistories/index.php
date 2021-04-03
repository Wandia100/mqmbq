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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Transaction Histories', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mpesa_payment_id',
            'reference_name',
            'reference_phone',
            'reference_code',
            //'station_id',
            //'station_show_id',
            //'amount',
            //'commission',
            //'status',
            //'is_archived',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
