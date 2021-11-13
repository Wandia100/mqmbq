<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Outbox */

$this->title = 'Send Bulk SMS';
$this->params['breadcrumbs'][] = ['label' => 'Outboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbox-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_bulk_form', [
        'model' => $model,
    ]) ?>

</div>
