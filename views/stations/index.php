<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stations-index">
    <p>
        <?= Html::a('Create Stations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'autoXlFormat'=>true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=> \kartik\grid\GridView::TARGET_BLANK
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'station_code',
            'address',
            'frequency',
            //'enabled',
            //'invalid_percentage',
            'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
        'pjax'=>true,
        'showPageSummary'=>true,
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'toggleDataOptions' => ['minCount' => 10],
        'panel'=>[
            'type'=>'default',
           // 'heading'=>'Users'
        ]
    ]); ?>


</div>
