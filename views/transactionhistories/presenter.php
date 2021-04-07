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

    <h1><?= Html::encode($show_name) ?></h1>
    <div class="row">
    <div class="col-md-6">
    <div class="card text-white bg-danger mb-3">
    <div class="card-body">
    <h5 class="card-text"><?=$target_achievement;?></h5>
    <p class="card-text">Target Achievement</p>
  </div>
</div>
    </div>
    <div class="col-md-6">
    <div class="card text-white bg-dark mb-3">
    <div class="card-body">
    <h5 class="card-text"><?=$transaction_count;?></h5>
    <p class="card-text">Total Transactions</p>
  </div>
</div>
    </div>
    </div> 

    <div class="row">
    <div class="col-md-4">
    <div class="card text-dark bg-light mb-3">
    <div class="card-body">
    <button class="btn btn-primary" type="button">Draw Winner</button>
    <p class="card-text"></p>
  </div>
</div>
    </div>
    <div class="col-md-8">
    <div class="card text-dark bg-light mb-3">
    <div class="card-header">Recent Winners</div>
    <div class="card-body">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>NAME</th>
            <th>REFERENCE</th>
            <th>AMOUNT</th>
            <th>DATE</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(count($recent_winners) > 0)
        {
            foreach($recent_winners as $row)
            {
                ?>
                <tr>
            <td><?=$row['reference_name'];?></td>
            <td><?=$row['reference_code'];?></td>
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

</div>
