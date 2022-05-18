<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
$this->title = 'Home';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-3">
                <div class="well well-lg text-dark" style="background-color: #FFFFFF">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format($today_income); ?></h5>
                    <p>Today</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well well-lg  text-white" style="background-color: #8950FC">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('yesterday'));?></h5>
                    <p>Yesterday</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well well-lg text-white" style="background-color: #F64E60">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('last_7_days')) ?></h5>
                    <p>Current Week</p>
                </div>
                
            </div>
            <div class="col-md-3">
                <div class="well well-lg text-white" style="background-color: #212121">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('currentmonth')) ?></h5>
                    <p>Current month</p>
                </div>
                
            </div>
        </div>
         <div class="row">
            <div class="col-md-3">
                <div class="well well-lg" style="background-color: #C9F7F5">
                <h5 class="font-weight-bold"><?=$currency;?> <?=number_format($today_payout);?></h5>
                    <p>Payouts today</p>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                <h5 class="font-weight-bold"><?=$currency;?> <?=number_format($yesterday_payout);?></h5>
                    <p>Payouts yesterday</p>
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
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('lastweek')); ?></h5>
                    <p>Last week</p>
                </div>
                <div class="well well-lg" style="background-color: #FFE2E5">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('lastmonth')); ?></h5>
                    <p>Last month</p>
                </div>
                
                <div class="well well-lg" style="background-color: #E1F0FF">
                    <h5 class="font-weight-bold"><?=$currency;?> <?=number_format(app\models\SiteReport::getSiteReport('totalrevenue')) ?></h5>
                    <p>Total revenue</p>
                </div>
            </div>
        </div>

    </div>
</div>
