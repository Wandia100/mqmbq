<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ForgotPass extends Model
{
    public $pass;
    public $confirm_pass;
    public $email;
    public $passcode;
    public $verifyCode;
    public $subject;
    public $name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email','pass', 'confirm_pass', 'passcode'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            #['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            #'verifyCode' => 'Verification Code',
            'email' => 'Email',
            'pass'  => 'Password',
            'confirm_pass' => 'Confirm password',
            'passcode' => 'Passcode'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendPassCode($email)
    {
        //Send Email
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody("Your com21 portal One time password(OTP) is : ".$this->passcode)
            ->send();
        
        //Send sms
    }
}
