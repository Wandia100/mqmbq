<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */
?>
<div class="col-sm-4">
        <p>
            <?= Html::a('Update station show', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-user"></span> tation show', ['view', 'id' => $model->id,'r' => 1], 
                    ['class' => (isset($_GET['r']) && isset($_GET['r']))]) ?>
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