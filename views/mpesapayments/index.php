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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mpesa Payments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'TransID',
            'FirstName',
            'MiddleName',
            'LastName',
            //'MSISDN',
            //'InvoiceNumber',
            //'BusinessShortCode',
            //'ThirdPartyTransID',
            //'TransactionType',
            //'OrgAccountBalance',
            //'BillRefNumber',
            //'TransAmount',
            //'is_archived',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
