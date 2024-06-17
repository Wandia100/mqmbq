<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistories */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Winning Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="winning-histories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'prize_id',
            'station_show_prize_id',
            'reference_name',
            'reference_phone',
            'reference_code',
            'station_id',
            'presenter_id',
            'station_show_id',
            'amount',
            'transaction_cost',
            'conversation_id',
            'transaction_reference',
            'status',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
        ],
    ]) ?>

</div>
