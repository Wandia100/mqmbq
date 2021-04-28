<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])**/ ?>
    </p>
    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    'national_id',
                    'date_of_birth',
                    'phone_number',
                    'email:email',
                    'profile_image',
                    'perm_group',
                    'defaultpermissiondenied',
                    'extpermission',
                    //'password',
                    'enabled',
                    'created_at',
                    'updated_at',
                    'created_by',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <p>
                <kbd> <b><?=$model -> first_name?> <?=$model -> last_name?> Permissions</b> </kbd> 
            </p>
            <?php $form = ActiveForm::begin( [ 'id' => 'entryform' ] ); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $model->extpermission = $perm;
                        echo $form->field( $model, 'extpermission' )->checkboxList(app\models\Permission::getPermissions())->label( "" ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?= Html::submitButton( 'Update', ['class' =>  'btn btn-block btn-success' ] ) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>


        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3>Activities</h3>
            <?= GridView::widget([
                'dataProvider' => $dataProviderActivity,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'description',
                    [
                        'attribute' => 'user',
                        'value'     => 'fullname'
                    ],
                    //'properties',
                    'created_at',
                ],
            ]); ?>
        </div>
    </div>
</div>
