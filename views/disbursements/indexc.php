<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$route = isset($_GET['t'])?$_GET['t']:'';
$this->title = $route == 'p'?'Presenters Disbursements':'Disbursements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stations-index">
    <p>
        <?php 
            if($route == ''){
                echo Html::a('Create Disbursements', ['create'], ['class' => 'btn btn-success']);
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= kartik\grid\GridView::widget([
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

           // 'id',
            'reference_id',
            'reference_name',
            'phone_number',
            'amount',
            //'conversation_id',
           # 'status',
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ( $model ) {
                    if ( $model->status == 1 ) {
                        return "Processed";
                    }else if ( $model->status == 2 ) {
                        return "Failed";
                    } else {
                        return "Pending";
                    }
                },
                'filter'    => array( '0' => 'Pending', '1' => 'Processed','2' =>'Failed' ),
            ],
            'disbursement_type',
            //'transaction_reference',
            'created_at',
            //'updated_at',
            //'deleted_at',
            
            
        ],
    ]); ?>


</div>
