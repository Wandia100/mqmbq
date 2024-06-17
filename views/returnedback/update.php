<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReturnedBack */

$this->title = 'Update Returned Back: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Returned Backs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="returned-back-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
