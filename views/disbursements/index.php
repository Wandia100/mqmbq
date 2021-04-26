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
            /*[
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
             * 
             */
            [
                 'attribute' => 'status',
                'format'=>'raw',
                'value' => function($model){
                    if(Yii::$app->user->identity->perm_group == 1 && in_array($model->status, [0,1,2,3])):
                        return Html::dropDownList( 'status' . str_replace('-', '_', $model->id), $model->status, ['0' => 'Pending','2'=>'Failed','3'=>'Retunr','1'=>'Processed'], [
                            'prompt'   => '',
                            "class"    => "form-control ",
                            'id'       => 'status' .str_replace('-', '_', $model->id),
                            "onchange" => "toggleDisbursement($(this),'status','$model->id')"
                        ]);
                    else:
                        if ( $model->status == 1 ) {
                            return "Processed";
                        }else if ( $model->status == 2 ) {
                            return "Failed";
                        } else if ( $model->status == 3 ) {
                            return "Return";
                        } else {
                            return "Pending";
                        }
                    endif;
                },
                'filter'    => array( '0' => 'Pending', '1' => 'Processed','2' =>'Failed','3' =>'return-overpaid' ),        
            ],

            
        ],
    ]); ?>


</div>
