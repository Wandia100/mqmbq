<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MpesaPaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mpesa Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mpesa-payments-index">
    <div class="row">
    <div class="panel panel-info col-md-8">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_datetime_filter_.php', [
                            'data' => [],
                            'url'  => '/mpesapayments/index',
                            'from' => date( 'Y-m-d H:i', strtotime( '-5 hours' ) )
                        ])?>
                </div>
                
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>
    <div class="col-md-4">
                    <div id="" class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-12">
                                    <b>Data upload portal</b>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding: 10px;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <b>CSV</b>  <?= $form->field($model, 'excelfile')->fileInput(['class' => '', 'onchange' => ''])->label('') ?>

                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            echo Html::submitButton('Upload Mpesa', ['class' => 'btn btn-primary btn-lg showprogressbar', 'name' => 'submitbtn', 'value' => 'set']); ?>
                                        </div>
                                    </div>
                                    <?php
                                    ActiveForm::end() ?>
                                </div>
                            </div>
                        </div>
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
