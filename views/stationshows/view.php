<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Station Shows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="station-shows-view">
    
    <div class="col-sm-3">
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                #'id',
                #'station_id',
                [
                    'label'  => 'subject_type',
                    'value'  => $model->stations->name,
                ],
                'name',
                'description:ntext',
                'show_code',
                'amount',
                'commission',
                'management_commission',
                'price_amount',
                'target',
                'draw_count',
                'invalid_percentage',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
                'start_time',
                'end_time',
                'enabled',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ]) ?>
    </div>
    <div class="col-sm-4">
        <b><button class="btn btn-success" onclick="presenterModal()"> Add Presenters</button></b>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            'fullname',
            'is_admin',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>
    </div>
    <div class="col-sm-5">
        <b><button class="btn btn-primary" onclick="prizeModal()"> Add Prizes</button></b>
        <?= GridView::widget([
        'dataProvider' => $prizeDataProvider,
       // 'filterModel' => $prizeSearchModel,
        'columns' => [

            'draw_count',
            //'amount',
            //'enabled',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>
    </div>
</div>

  <!-- Modal -->
  <?php

echo Html::beginForm(
	$action = yii\helpers\Url::base() . "/stationshows/addpresenter?id=$model->id",
	$method = 'post',
	$hmtmlOptions = array( 'id' => 'addpresenterform' )
);
?>
  <div class="modal fade" id="presentersModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Presenter</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <div class="col-sm-12">
                <?= Html::dropDownList( 'presenter_id','', \app\models\Users::getUsersList(4), [
                            'prompt'   => '--Select--',
                            'id'       => 'presenterid',
                            'class'    => 'form-control',
                        ] ) ?>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"class="btn btn-primary btn-block" id="addpresenterbtn"><span style="font-weight: bold">Add presenter</span></button>
        </div>
      </div>
      
    </div>
  </div>
  <?php echo Html::endform(); ?>

  
  <!-- Modal -->
  <?php

echo Html::beginForm(
	$action = yii\helpers\Url::base() . "/stationshows/addprize?id=$model->id",
	$method = 'post',
	$hmtmlOptions = array( 'id' => 'addprizeform' )
);
?>
  <div class="modal fade" id="prizeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Prize</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <div class="col-sm-12">
                <b>Draw counts</b>
                <?= Html::textInput('draw_count', '', ['class'    => 'form-control', 'id'=> 'draw_count'])?>
            </div>
            <div class="col-sm-12">
                <b>Monday</b>
                <?= Html::textInput('monday', '', ['class'    => 'form-control', 'id'=> 'monday'])?>
            </div>
            <div class="col-sm-12">
                <b>Tuesday</b>
                <?= Html::textInput('tuesday', '', ['class'    => 'form-control', 'id'=> 'tuesday'])?>
            </div>
            <div class="col-sm-12">
                <b>Wednesday</b>
                <?= Html::textInput('wednesday', '', ['class'    => 'form-control', 'id'=> 'wednesday'])?>
            </div>
            <div class="col-sm-12">
                <b>Thursday</b>
                <?= Html::textInput('thursday', '', ['class'    => 'form-control', 'id'=> 'thursday'])?>
            </div>
            <div class="col-sm-12">
                <b>Friday</b>
                <?= Html::textInput('friday', '', ['class'    => 'form-control', 'id'=> 'friday'])?>
            </div>
            <div class="col-sm-12">
                <b>Saturday</b>
                <?= Html::textInput('saturday', '', ['class'    => 'form-control', 'id'=> 'saturday'])?>
            </div>
            <div class="col-sm-12">
                <b>Enabled</b>
                <?= Html::dropDownList( 'enabled','', ['1'=>'Yes','0' => 'No'], [
                            'prompt'   => '--Select--',
                            'id'       => 'enabledid',
                            'class'    => 'form-control',
                        ] ) ?>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"class="btn btn-primary btn-block" id="addprizebtn"><span style="font-weight: bold">Add prize</span></button>
        </div>
      </div>
      
    </div>
  </div>
  <?php echo Html::endform(); ?>