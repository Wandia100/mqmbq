<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Prizes */

$this->title = 'Create Prizes';
$this->params['breadcrumbs'][] = ['label' => 'Prizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prizes-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
