<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row"> 
         <?= $this->render('//_notification'); ?>         
    </div>
    <?php if (Yii::$app->session->hasFlash('forgotpass')): ?>

        <div class="alert alert-success">
            Kindly check the passcode in as an SMS or Email
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have forgotten your password, kindly provide the details below for reset.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'forgotpass-form']); ?>

                    <?php
                        if($model->passstate == 1){
                           echo $form->field($model, 'email')->textInput(['autofocus' => true]); 
                        }else{
                            echo $form->field($model, 'email')->hiddenInput()->label(false);
                        }
                    ?>


                    <?php
                        if(in_array($model->passstate, [2,3,4])){
                           $remattempts = $model->attempts == 0? 3: 4-$model->attempts;
                           echo 'Remaining attempts ='.$remattempts; 
                           echo $form->field($model, 'passcode') ;
                        }else{
                            echo $form->field($model, 'passcode')->hiddenInput()->label(false);
                        }
                    ?>
                
                    <?php
                        if($model->passstate == 6){
                            echo $form->field($model, 'pass')->passwordInput(['autocomplete'=>'off']);
                        }else{
                            echo $form->field($model, 'pass')->hiddenInput()->label(false);
                        }
                    ?>

                    <?php
                        if($model->passstate == 6){
                           echo $form->field($model, 'confirm_pass')->passwordInput(['autocomplete'=>'off']); 
                        }else{
                            echo $form->field($model, 'confirm_pass')->hiddenInput()->label(false);
                        }
                    ?>


                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
