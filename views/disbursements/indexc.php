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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'reference_id',
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
                'header'=>'action',
                'format'=>'raw',
                'value' => function($model) use ($route){
                    if($route == 'p'):
                        return $model->status == 1 ? 'Processed': Html::a('<span class="glyphicon glyphicon-wrench">PENDING(Change Status)</span>', ['#','id'=>$model->id]);;
                    else:
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view','id'=>$model->id]);
                    endif;
                    
                }
            ],
            
        ],
    ]); ?>


</div>
