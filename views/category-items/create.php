<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryItems */

$this->title = 'Create Categoryitems';
$this->params['breadcrumbs'][] = ['label' => 'Category Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
