<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SmsCategory */

$this->title = 'Create Sms Category';
$this->params['breadcrumbs'][] = ['label' => 'Sms Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
