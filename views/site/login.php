<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
?>

<div class="signupform">
    <div class="container">
        <!-- main content -->
        <div class="agile_info">
            <div class="w3l_form">
                <div class="left_grid_info">
                    <h1>Com21</h1>
                        <p>Welcome to the Com21 Raffle platform. This is a management platform for all Com21 Raffle features</p>
                        
                </div>
            </div>
            <div class="row"> 
                 <?= $this->render('//_notification'); ?>         
            </div>  
            <div class="w3_info">
                <h2>Login to your Account</h2>
                <p>Enter your details to login.</p>
                  
            
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <label>Username</label>
                <?= $form->field($model, 'username')->textInput(['required' => true, 'placeholder' => 'Enter username'])->label(false) ?>

                <label>Password</label>
                <?= $form->field($model, 'password')->passwordInput(['required' => true, 'placeholder' => "Enter Password"])->label(false) ?>

                <div class="login-check">
                    <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i> Remember me</label>
                </div>	
                <?= Html::submitButton('Login', ['class' => 'btn btn-danger btn-block', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
                <p class="account">By clicking login, you agree to our <a href="#">Terms & Conditions!</a></p>
                	
                <div class="forgot-password">
                    <br/>
                  <p class="">Click , <?= Html::a('Forgot password ?', ['/site/forgotpass'], [''])?></p>
                </div>
            </div>
        </div>
        <!-- //main content -->
    </div>
</div>

