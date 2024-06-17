<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Commissions */

$this->title = 'Create Commissions';
$this->params['breadcrumbs'][] = ['label' => 'Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commissions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
