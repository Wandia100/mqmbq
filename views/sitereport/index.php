<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SiteReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Site Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Site Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'report_name',
            'report_value',
            'report_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
