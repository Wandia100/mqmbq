<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disbursements */

$this->title = 'Create Disbursements';
$this->params['breadcrumbs'][] = ['label' => 'Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursements-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
