<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sales', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sale_time',
            'customer_id',
            'employee_id',
            'comment:ntext',
            'invoice_number',
            //'quote_number',
            //'sale_id',
            //'sale_status',
            //'dinner_table_id',
            //'work_order_number',
            //'sale_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
