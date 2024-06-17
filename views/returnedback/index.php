<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReturnedBackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Returned Backs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returned-back-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Return', ['adminretun'], ['class' => 'btn btn-primary']) ?>
    </p>

    <p>
        <?php #= Html::a('Create Returned Back', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'category_item_id',
            'name',
            'howmany',
            'outprice',
            //'enabled',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
