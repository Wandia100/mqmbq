<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Outbox;
use app\components\OutboxJob;

/**
 * ContactForm is the model behind the contact form.
 */
class ForgotPass extends Model
{
    public $pass;
    public $confirm_pass;
    public $email;
    public $passcode;
    public $passstate;
    public $verifyCode;
    public $subject;
    public $name;
    public $attempts =0;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email'], 'required','on' => 'sc_email'],
            [['passcode'], 'required','on' => 'sc_code'],
            [['pass', 'confirm_pass'], 'required','on' => 'sc_resetpass'],
            [['passcode'], 'integer'],
            [['pass', 'confirm_pass'], 'string', 'min' => 6],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
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
    public function sendPassCode($userrecord)
    {
        //Send Email
        /*Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody("Your com21 portal One time password(OTP) is : ".$this->passcode)
            ->send();
         * 
         */
        
        //Send sms
        $outbox= new Outbox();
        $outbox->receiver=$userrecord->phone_number;
        $outbox->message="Your one time password is ".$userrecord->pass_code;
        $outbox->sender="default";
        $outbox->category=1;
        $outbox->status=0;
        $outbox->created_date=date("Y-m-d H:i:s");
        $outbox->save(false);
        Yii::$app->queue->push(new OutboxJob(['id'=>$outbox->id]));
        return TRUE;
    }
    /**
     * 
     * @param type $userrecord
     */
    public function processPassCode($userrecord){
        $expiry = date('Y-m-d H:i:s', strtotime('+1 minute',time()));
        $userrecord->pass_state = 2;
        $userrecord->pass_code = mt_rand(1000,9999);
        $userrecord->pass_expiry = $expiry;
        if($this->sendPassCode($userrecord)){
            $userrecord->save(false);
            Yii::$app->session->setFlash('success','password code to your email and phone. check sms or mail');
        }
        return TRUE;
    }
    /**
     * 
     * @param type $userrecord
     */
    public function proceeNewPass($userrecord){
        $userrecord->password = password_hash($this->pass, PASSWORD_BCRYPT, array('cost' => 5));
        $userrecord->pass_code =  NULL;
        $userrecord->pass_state =  7;//password changed
        $userrecord->save(FALSE);
        /*$act = new \app\models\ActivityLog();
        $act -> desc = "users password change";
        $act -> propts = "'{id:$userrecord->id }'";
        $act ->setLog();*/
        return TRUE;
    }
}
