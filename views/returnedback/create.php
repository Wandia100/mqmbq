<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReturnedBack */

$this->title = 'Create Returned Back';
$this->params['breadcrumbs'][] = ['label' => 'Returned Backs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returned-back-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
