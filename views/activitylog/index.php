<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivityLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Activity Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'description',
            'causer_id',
            'properties',
            'created_at',
            //'updated_at',
            //'is_deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
