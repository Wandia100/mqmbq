<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisbursementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursements-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Disbursements', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'reference_id',
            'reference_name',
            'phone_number',
            'amount',
            //'conversation_id',
            //'status',
            //'disbursement_type',
            //'transaction_reference',
            //'created_at',
            //'updated_at',
            //'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
