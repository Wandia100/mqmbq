<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionHistoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presenter DashBoard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-histories-index">

    <h1><?= Html::encode(strtoupper($show_name)) ?></h1>
    <div class="row">
    <div class="col-md-6">
    <div class="card text-white bg-danger mb-3">
    <div class="card-body">
    <h5 class="card-text font-weight-bold"><?=$target_achievement;?>%</h5>
    <p class="card-text">Target Achievement</p>
  </div>
</div>
    </div>
    <div class="col-md-6">
    <div class="card text-white bg-dark mb-3">
    <div class="card-body">
    <h5 class="card-text font-weight-bold"><?=number_format($transaction_count);?></h5>
    <p class="card-text">Total Transactions</p>
  </div>
</div>
    </div>
    </div> 

    <div class="row">
    <div class="col-md-4">
    <div class="card text-dark bg-light mb-3">
    <div class="card-body">
    <?php
    ?>
    <div id="pie-chart" style="width:100%; height:400px;"></div>
    <p class="card-text"></p>
  </div>
</div>
    </div>
    <div class="col-md-8">
    <div class="card text-dark bg-light mb-3">
    <div class="card-header">Recent sales</div>
    <div class="card-body">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>CATEGORY</th>
            <th>ITEM</th>
            <th>QUANTITY</th>
            <th>AMOUNT</th>
            <th>DATE</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(count($recent_sales) > 0)
        {
            foreach($recent_sales as $row)
            {
                ?>
                <tr>
            <td><?=$row['category_name'];?></td>
            <td><?=$row['category_item_name'];?></td>
            <td><?=$row['quantity'];?></td>
            <td><?=$row['amount'];?></td>
            <td><?=$row['created_at'];?></td>
            </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
  </div>
</div>
    </div>
    </div> 
    <!--start of hidden divs -->
    <div id="percent_raised" style="display:none;"><?=$percent_raised;?></div>
    <div id="percent_pending" style="display:none;"><?=$percent_pending;?></div>
    <!--end of hidden divs -->






</div>





<!--  draw winner Modal    -->
<div id="draw_winner_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">X</a>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4><span id="draw_title"></span></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <input type=hidden name=bu id=bu value="">
                <input type=hidden name=bunit id=bunit value="">

                <div class="container-fluid">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 text-center" id="prizes-grid">
                            <h4><span id="winner_number"> 0 0 0 0 0 0 0 0 0 0 0 0</span></h4>
                            <h4><span id="winner_name"><?=(count($show_prizes) > 0?"WAITING FOR DRAW":"NO DRAWS LEFT FOR PRIZE(S)");?></span></h4>
                                <?php
                                for($i=0;$i < count($show_prizes); $i++)
                                {
                                    $row=$show_prizes[$i];
                                    $station_show_id=$presenter_station_show['station_show_id'];
                                    $presenter_id=$presenter_station_show['presenter_id'];
                                    $prize_id=$row['prize_id'];
                                    ?>
                                    <button id="<?=$row['prize_id'];?>" class="btn btn-danger" onclick="drawPrize('<?=$station_show_id;?>','<?=$presenter_id;?>','<?=$prize_id;?>','<?=$from;?>',0,'<?=$from;?>')" type="button"><?=$row['name'];?></button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
