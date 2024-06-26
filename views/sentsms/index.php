<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sent Sms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'receiver',
            'sender',
            'message:ntext',
            'created_date',
            'category',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
