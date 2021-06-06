<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commissions-index">
      <div class="row"> 
                            <div class="col-12" style="text-align: center;font-weight: bold">
                                <?= $this->render('//_notification'); ?>  
                            </div>
                                    
                        </div>
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                        <?=$this->renderFile('@app/views/layouts/partials/_date_filter.php', [
                                'data' => ['t' => isset($_GET['t']) ?$_GET['t'] :'p'],
                                'url'  => '/commissions/index',
                                'from' => date( 'Y-m-d', strtotime( '-42 days' ) )
                        ])?>
                </div>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
           # 'user_id',
            [
                'attribute' => 'user',
                'value'     => 'fullname'
            ],
            #'station_id',
            [
                'attribute' => 'stationname',
                'value'     => 'stations.name'
            ],
            #'station_show_id',
            [
                'attribute' => 'stationshowname',
                'value'     => 'stationshows.name'
            ],
            'amount',
            'transaction_cost',
            'transaction_reference',
            'status',
            'created_at',
            //'updated_at',
            //'deleted_at',
            [
                'header'=>'action',
                'format'=>'raw',
                'value' => function($model){
                    if($model->status == 0 && in_array($model->c_type,[3,4]))
                    {
                        return Html::a('<span class="">Disburse</span>', ['index','id'=>$model->id,'t'=>'p']);
                    }
                    else 
                    {
                        return "Disbursed";
                    }
                }
            ],
        ],
    ]); ?>


</div>


  <!-- Modal -->
<?php
if(isset($_GET['id'])){
    echo Html::beginForm(
            $action = Url::to(['/commissions/index','t'=>$_GET['t'],'criterion'=>(isset($_GET['criterion'])?$_GET['criterion']:"")]),
            $method = 'post',
            $hmtmlOptions = array('id' => 'commissiondisbursementform' )
    );
?>
  <div class="modal fade" id="commissiondisbursementModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Split Presenter commission</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <div class="col-sm-12">
                <input type="hidden" name="commmission_id" value="<?=$_GET['id']?>" />
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>first_name</th>
                            <th>last_name</th>
                            <th>phone_number</th>
                            <th>email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($presenters as $value){
                        ?>
                            <tr>
                                <th><input type="checkbox" name="presenter[]" value="<?=$value->id?>"></th>
                                <th><?=$value->first_name?></th>
                                <th><?=$value->last_name?></th>
                                <th><?=$value->phone_number?></th>
                                <th><?=$value->email?></th>
                            </tr>
                        
                        
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"class="btn btn-primary btn-block" id="commissiondisbursementbtn"><span style="font-weight: bold">Split commission</span></button>
        </div>
      </div>
      
    </div>
  </div>
<?php echo Html::endform(); } ?>
