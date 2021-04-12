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
    <div class="row">
    <div class="col-sm-3">
        <p>
            <?= Html::a('Update station show', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
    <div class="col-sm-3">
        <b><button class="btn btn-success" onclick="presenterModal()"> Add Presenters</button></b>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            'fullname',
            'is_admin',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $data) {
                        return Html::a('<span class="glyphicon glyphicon-trash" title="Delete"></span>', ['stationshowpresenters/delete', 'id' => $data->id], [ 'onClick' => 'return confirm("Are you sure you want to delete this item?")','method' => 'post']);
                    },
                ],
            ],

        ],
    ]); ?>
    </div>
    <div class="col-sm-6">
        <b><button class="btn btn-primary" onclick="prizeModal()"> Add Prizes</button></b>
        <?= GridView::widget([
        'dataProvider' => $prizeDataProvider,
       // 'filterModel' => $prizeSearchModel,
        'columns' => [
            'draw_count',
            [
                'attribute' => 'monday',
                'value'     => 'mondayprize.name'
            ],
            [
                'attribute' => 'tuesday',
                'value'     => 'tuesdayprize.name'
            ],
            [
                'attribute' => 'wednesday',
                'value'     => 'wednesdayprize.name'
            ],
            [
                'attribute' => 'thursday',
                'value'     => 'thursdayprize.name'
            ],
            [
                'attribute' => 'friday',
                'value'     => 'fridayprize.name'
            ],
            [
                'attribute' => 'saturday',
                'value'     => 'saturdayprize.name'
            ],
            [
                'attribute' => 'sunday',
                'value'     => 'sundayprize.name'
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}{update}',
                'buttons' => [
                    'delete' => function ($url, $data) {
                        return Html::a('<span class="glyphicon glyphicon-trash" title="Delete"></span>', ['stationshowprizes/delete', 'id' => $data->id], [ 'onClick' => 'return confirm("Are you sure you want to delete this item?")','method' => 'post']);
                    },
                    'update' => function ($url, $data) {
                        return "<span class='glyphicon glyphicon-pencil' title='edit' onclick='editPrizeModal(\"$data->id\",\"$data->draw_count\",\"$data->monday\",\"$data->tuesday\",\"$data->wednesday\",\"$data->thursday\",\"$data->friday\",\"$data->saturday\",\"$data->sunday\",\"$data->enabled\")'></span>";
                    },
                ],
            ],
        ],
    ]); ?>
    </div>
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
            <h4 class="modal-title"><span class="addprizespn" style="font-weight: bold">Add prize</span></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <div class="col-sm-12">
                <b>Draw counts</b>
                <?= Html::hiddenInput('showprizeid', '', ['id'=> 'showprizeid'])?>
                <?= Html::textInput('draw_count', '', ['class'    => 'form-control', 'id'=> 'draw_count'])?>
            </div>
            <div class="col-sm-12">
                <b>Monday</b>
                <?= Html::dropDownList('monday', '', \app\models\Prizes::getPrizesList(),['prompt'=>'--Select--','class'=> 'form-control', 'id'=> 'monday'])?>
            </div>
            <div class="col-sm-12">
                <b>Tuesday</b>
                <?= Html::dropDownList('tuesday', '', \app\models\Prizes::getPrizesList(),['prompt'=>'--Select--','class'=> 'form-control', 'id'=> 'tuesday'])?>
            </div>
            <div class="col-sm-12">
                <b>Wednesday</b>
                <?= Html::dropDownList('wednesday', '', \app\models\Prizes::getPrizesList(),['prompt'=>'--Select--','class'=>'form-control', 'id'=> 'wednesday'])?>
            </div>
            <div class="col-sm-12">
                <b>Thursday</b>
                <?= Html::dropDownList('thursday', '', \app\models\Prizes::getPrizesList(),['prompt'=>'--Select--','class'=>'form-control', 'id'=> 'thursday'])?>
            </div>
            <div class="col-sm-12">
                <b>Friday</b>
                <?= Html::dropDownList('friday', '', \app\models\Prizes::getPrizesList(),['prompt'=>'--Select--','class'=> 'form-control', 'id'=> 'friday'])?>
            </div>
            <div class="col-sm-12">
                <b>Saturday</b>
                <?= Html::dropDownList('saturday', '', \app\models\Prizes::getPrizesList(),['prompt'=> '--Select--','class' => 'form-control', 'id'=> 'saturday'])?>
            </div>
            <div class="col-sm-12">
                <b>Sunday</b>
                <?= Html::dropDownList('sunday', '', \app\models\Prizes::getPrizesList(),['prompt'=> '--Select--','class'=> 'form-control', 'id'=> 'sunday'])?>
            </div>
            <div class="col-sm-12">
                <b>Enabled</b>
                <?= Html::dropDownList( 'enabled','', ['1'=>'Yes','0' => 'No'], ['prompt'=> '--Select--','id'=> 'enabled','class'=>'form-control'])?>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"class="btn btn-primary btn-block" id="addprizebtn"><span class="addprizespn" style="font-weight: bold">Add prize</span></button>
        </div>
      </div>
      
    </div>
  </div>
  <?php echo Html::endform(); ?>