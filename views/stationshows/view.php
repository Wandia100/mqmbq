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
        <b><button class="btn btn-primary"> Add Prizes</button></b>
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