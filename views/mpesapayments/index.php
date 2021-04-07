<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MpesaPaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mpesa Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mpesa-payments-index">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => [],
                                'url'  => '/mpesapayments/index',
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
            'TransID',
            'FirstName',
            'MiddleName',
            'LastName',
            'MSISDN',
            //'InvoiceNumber',
            //'BusinessShortCode',
            //'ThirdPartyTransID',
            //'TransactionType',
            //'OrgAccountBalance',
            'BillRefNumber',
            'TransAmount',
            //'is_archived',
            'created_at',
            //'updated_at',
            //'deleted_at',

        ],
    ]); ?>


</div>
