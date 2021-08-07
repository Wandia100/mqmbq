<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SiteReport */

$this->title = 'Create Site Report';
$this->params['breadcrumbs'][] = ['label' => 'Site Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
