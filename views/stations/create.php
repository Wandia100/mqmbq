<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stations */

$this->title = 'Create Stations';
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stations-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
