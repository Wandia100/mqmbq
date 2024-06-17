<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PermissionGroup */

$this->title = 'Create Permission Group';
$this->params['breadcrumbs'][] = ['label' => 'Permission Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
