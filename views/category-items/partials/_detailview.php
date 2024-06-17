<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\StationShows */
?>
<div class="col-sm-4">
        <p>
            <?= Html::a('Update category items', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-user"></span> category items', ['view', 'id' => $model->id,'r' => 1], 
                    ['class' => (isset($_GET['r']) && isset($_GET['r']))]) ?>
        </p>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                #'id',
                #'category_id',
                [
                    'label'  => 'subject_type',
                    'value'  => $model->categories->name,
                ],
                'name',
                'description',
                'generate_barcode',
                'item_code',
                'inprice',
                'outprice',
                'quantity',
                'target',
                'enabled',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ]) ?>
    </div>