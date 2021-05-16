<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
$this->title = 'Com 21';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-3">
                <div class="well well-lg text-dark" style="background-color: #FFFFFF">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('today')?></h5>
                    <p>Today</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well well-lg  text-white" style="background-color: #8950FC">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('yesterday')?></h5>
                    <p>Yesterday</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well well-lg text-white" style="background-color: #F64E60">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('last_7_days')?></h5>
                    <p>Current Week</p>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="well well-lg text-white" style="background-color: #212121">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('currentmonth')?></h5>
                    <p>Current month</p>
                </div>
                
            </div>
        </div>
         <div class="row">
            <div class="col-md-3">
                <div class="well well-lg" style="background-color: #C9F7F5">
                    <kbd>Payouts today</kbd> <br/>
                    <span></span>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                    <kbd>Commissions</kbd><br/>
                    <span></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="well well-lg" style="background-color: #FFFFFF">
                    <kbd>Recent winners</kbd><br/>
                    <span>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                           // 'filterModel' => $searchModel,
                            'layout' => "{items}",
                            'columns' => [
                                [
                                    'attribute' => 'prizename',
                                    'value'     => 'prizes.name'
                                ],
                                'reference_name',
                                [
                                    'attribute' => 'stationname',
                                    'value'     => 'stations.name'
                                ],
                                [
                                    'attribute' => 'stationshowname',
                                    'value'     => 'stationshows.name'
                                ],
                                'amount',

                            ],
                        ]); ?>
                    </span>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="well well-lg" style="background-color: #C9F7F5">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('lastweek')?></h5>
                    <p>Last week</p>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('lastmonth')?></h5>
                    <p>Last month</p>
                </div>
                
                <div class="well well-lg" style="background-color: #E1F0FF">
                    <h5 class="font-weight-bold">Ksh <?= \app\models\MpesaPayments::getMpesaCounts('totalrevenue')?></h5>
                    <p>Total revenue</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="well well-lg" style="background-color:#FFFFFF">
                    <kbd>Shows summary (current month)</kbd><br/>
                   
                </div>
            </div>
        </div>
    </div>
</div>
