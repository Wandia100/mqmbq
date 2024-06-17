<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name .' Profile';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">
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
            <table>
                <thead></thead>
                <tbody>
                    <tr>
                        <?php 
                            $count =1;
                            foreach ($perm As $value){
                                echo "<td> - $value->name</td>";
                                if(($count % 3) == 0){
                                    echo '</tr><tr>';
                                }
                                $count++; 
                            }
                        ?>
                    </tr>    
                </tbody>
            </table>


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
