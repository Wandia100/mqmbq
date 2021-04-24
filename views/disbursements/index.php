<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisbursementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursements-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/disbursements/index',
                                'from' => date( 'Y-m-d', strtotime( '-42 days' ) )
                        ])?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           # 'reference_id',
            
           /* [
                'attribute' => 'user',
                'value'     => 'fullname'
            ],
            * 
            */
            'reference_name',
            'phone_number',
            'amount',
            //'conversation_id',
            'status',
            'disbursement_type',
            //'transaction_reference',
            'created_at',
            //'updated_at',
            //'deleted_at',
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function ( $model ) {
                    if ( $model->status == 1 ) {
                        return "Processed";
                    }else if ( $model->status == 2 ) {
                        return "Failed";
                    } else if ( $model->status == 3 ) {
                        return "Return";
                    } else {
                        return "Pending";
                    }
                },
                'filter'    => array( '0' => 'Pending', '1' => 'Processed','2' =>'Failed','3' =>'return-overpaid' ),
            ],
            [
                'header'=>'action',
                'format'=>'raw',
                'value' => function($model) use ($route){
                    if(Yii::$app->user->identity->perm_group == 1):
                        return in_array($model->status, [2,3]) ? Html::a('<span class="glyphicon glyphicon-wrench">PENDING(Change Status)</span>', ['index','id'=>$model->id,'srr'=>'failed']): 'ok';
                    else:
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','id'=>$model->id]);
                    endif;
                }
            ],

            
        ],
    ]); ?>


</div>
