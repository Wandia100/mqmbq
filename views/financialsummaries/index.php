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
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/financialsummaries/index',
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
            'mpesa_today',
            'mpesa_total',
            'transaction_history_today',
            'transaction_history_total',
            'created_at',
            //'updated_at',

        ],
    ]); ?>


</div>
