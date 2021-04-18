<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
$this->title = 'Com 21';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-3">
                <div class="well well-lg" style="background-color: #FFFFFF">
                    <kbd>Today</kbd> <br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('today')?></span>
                </div>
            </div>
            <div class="col-3">
                <div class="well well-lg" style="background-color: #8950FC">
                    <kbd>Yesterday</kbd><br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('yesterday')?></span>
                </div>
            </div>
            <div class="col-3">
                <div class="well well-lg" style="background-color: #F64E60">
                    <kbd>Last 7 days</kbd><br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('last_7_days')?></span>
                </div>
                
            </div>
            <div class="col-3">
                <div class="well well-lg" style="background-color: #212121">
                    <kbd>Current month</kbd><br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('currentmonth')?></span>
                </div>
                
            </div>
        </div>
         <div class="row">
            <div class="col-4">
                <div class="well well-lg" style="background-color: #C9F7F5">
                    <kbd>Payouts today</kbd> <br/>
                    <span></span>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                    <kbd>Commissions</kbd><br/>
                    <span></span>
                </div>
            </div>
            <div class="col-5">
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
            <div class="col-3">
                <div class="well well-lg" style="background-color: #C9F7F5">
                    <kbd>Last week</kbd><br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('lastweek')?></span>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                    <kbd>Last month</kbd><br/>
                    <span>Ksh  <?= \app\models\MpesaPayments::getMpesaCounts('lastmonth')?></span>
                </div>
                
                <div class="well well-lg" style="background-color: #E1F0FF">
                    <kbd>Total revenue</kbd><br/>
                    <span>Ksh <?= \app\models\MpesaPayments::getMpesaCounts('totalrevenue')?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="well well-lg" style="background-color:#FFFFFF">
                    <kbd>Shows summary (current month)</kbd><br/>
                   
                </div>
            </div>
        </div>
    </div>
</div>
