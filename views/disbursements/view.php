<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursements */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="disbursements-view">


    <p>
        
        <?= Html::a('Create Disbursements', ['create'], ['class' => 'btn btn-success']) ?>
        <?php //Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Back', ['indexc'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reference_id',
            'reference_name',
            'phone_number',
            'amount',
            'conversation_id',
            'status',
            'disbursement_type',
            'transaction_reference',
            'created_at',
            'updated_at',
            'deleted_at',
        ],
    ]) ?>

</div>
