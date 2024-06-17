<?php


use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Itemsales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemsale-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # Html::a('Create Itemsale', ['create'], ['class' => 'btn btn-success']) ?>
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

            //'id',
            //'category_id',
            'name',
           // 'description:ntext',
            'generate_barcode',
            //'item_code',
            //'inprice',
            'outprice',
            'quantity',
            //'target',
            //'enabled',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{sale} {return}',
                'buttons' => [
                    'sale' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-shopping-cart"></span>',
                            ['itemsale/sale', 'id' => $model->id],
                               [
                                'title' => Yii::t('yii', 'Sale'),

                               ]
                        );
                    },
                        'return' => function ($url, $model, $key) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-repeat"></span>', 
                                ['returnedback/returned', 'id' => $model->id],
                                [
                                    'title' => Yii::t('yii', 'return'),
                                ]
                            );
                        },
                ],
            ],
        ],
        'pjax'=>true,
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

