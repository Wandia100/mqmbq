<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistories */

$this->title = 'Update Winning Histories: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Winning Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="winning-histories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
