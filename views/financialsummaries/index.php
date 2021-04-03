<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FinancialSummariesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Summaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-summaries-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Financial Summaries', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'mpesa_today',
            'mpesa_total',
            'transaction_history_today',
            'transaction_history_total',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
