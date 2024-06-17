<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoryItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Items';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="category-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category Items', ['create'], ['class' => 'btn btn-success']) ?>
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

           //'category_id',
           [
            'attribute' => 'categoryname',
            'value'     => 'categories.name'
        ],
            'name',
            'description:ntext',
            'generate_barcode',
            'item_code',
            'inprice',
            'outprice',
            'quantity',
            'target',
            //'enabled',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],'pjax'=>true,
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
