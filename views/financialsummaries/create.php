<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FinancialSummaries */

$this->title = 'Create Financial Summaries';
$this->params['breadcrumbs'][] = ['label' => 'Financial Summaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-summaries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
