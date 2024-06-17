<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                 'data' => [],
                                'url'  => '/transactions/index',
                                'from' => date( 'Y-m-d', strtotime( '-42 days' ) )
                        ])?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>

    <?=  kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=> \kartik\grid\GridView::TARGET_BLANK
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'toolbar' => [
            '{toggleData}',
                    '{export}',
        ],
        'panel'=>[
            'type'=>'primary',
            'heading'=>'transactionhistories'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'user_id',
                'value' => 'user.first_name',
                'label' => 'First Name',
            ],
            //'user_id',
            // [
            //     'attribute' => 'user',
            //     'value'     => 'user.first_name'
            // ],
            //'category_id',
            [
                'attribute' => 'category_id',
               'value' => 'category.name',
               'label' => 'Category Name',
            ],
           // 'category_item_id',
            'name',
            //'description:ntext',
            //'item_code',
            'mode_payment',
            'amount',
            'quantity',
            'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {return}',
            'buttons' => [
                'return' => function ($url, $model, $key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-repeat"></span>', 
                        ['transactions/cancel', 'id' => $model->id],
                        [
                            'title' => Yii::t('yii', 'return'),
                        ]
                    );
                },
            ],
        ],
        ],
    ]); ?>


</div>
