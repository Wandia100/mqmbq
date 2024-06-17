<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PermissionGroup */

$this->title = 'Update Permission Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permission Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="permission-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
