<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PrizesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prizes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prizes-index">

    <p>
        <?= Html::a('Create Prizes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            'description',
           // 'mpesa_disbursement',
           // 'enabled',
            'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
        ],
    ]); ?>


</div>
