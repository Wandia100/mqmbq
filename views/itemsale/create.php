<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Itemsale */

$this->title = 'Create Itemsale';
$this->params['breadcrumbs'][] = ['label' => 'Itemsales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemsale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
