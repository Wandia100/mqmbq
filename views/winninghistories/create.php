<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WinningHistories */

$this->title = 'Create Winning Histories';
$this->params['breadcrumbs'][] = ['label' => 'Winning Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winning-histories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
