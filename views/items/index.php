<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'category',
            'supplier_id',
            'item_number',
            'description',
            //'cost_price',
            //'unit_price',
            //'reorder_level',
            //'receiving_quantity',
            //'item_id',
            //'pic_filename',
            //'allow_alt_description',
            //'is_serialized',
            //'stock_type',
            //'item_type',
            //'deleted',
            //'custom1',
            //'custom2',
            //'custom3',
            //'custom4',
            //'custom5',
            //'custom6',
            //'custom7',
            //'custom8',
            //'custom9',
            //'custom10',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
