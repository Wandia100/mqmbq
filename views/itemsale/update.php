<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Itemsale */

$this->title = 'Update Itemsale: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Itemsales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="itemsale-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
