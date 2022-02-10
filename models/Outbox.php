<?php

namespace app\models;

use Yii;
use app\components\Myhelper;

/**
 * This is the model class for table "outbox".
 *
 * @property int $id
 * @property string|null $receiver
 * @property string|null $sender
 * @property string|null $message
 * @property string $created_date
 * @property int|null $status
 * @property int $category
 */
class Outbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbox';
    }
    public static function getDb() {
        return Yii::$app->sms_db;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['created_date'], 'safe'],
            [['status', 'category'], 'integer'],
            [['receiver', 'sender'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receiver' => 'Receiver',
            'sender' => 'Sender',
            'message' => 'Message',
            'created_date' => 'Created Date',
            'status' => 'Status',
            'category' => 'Category',
        ];
    }
    public static function saveOutbox($receiver,$message,$category)
    {
        $outbox=new Outbox();
        $outbox->message=$message;
        $outbox->receiver=$receiver;
        $outbox->category=$category;
        $outbox->save(false);
    }
    public static function getOutbox($limit)
    {
        $smses=Outbox::find()->where(['status'=>1])->limit($limit)->all();
        $pending=[];
        for($i=0;$i <count($smses); $i++)
        {
            $sms=$smses[$i];
            $sent_sms=new SentSms();
            $sent_sms->receiver=$sms->receiver;
            $sent_sms->message=$sms->message;
            $sent_sms->category=$sms->category;
            $sent_sms->category=$sms->category;
            $sent_sms->created_date=$sms->created_date;
            $sent_sms->save(false);
            $pen=[
                "msisdn"=> $sent_sms->receiver,
                'sender'=>$sent_sms->sender,
                "message"=>$sent_sms->message
            ];
            $sms->delete(false);
            array_push($pending,$pen);
        }
        return $pending;
    }
    public static function insertBulk($message)
    {
        $result= MpesaPayments::find()->select(['MSISDN'])->distinct()->all();
        foreach($result as $row)
        {
            $model=new Outbox();
            $model->receiver=$row['MSISDN'];
            $model->sender=SENDER_NAME;
            $model->message=$message;
            $model->status=1;
            $model->save(false);
        }
        
    }
    public static function nitextBatch($limit)
    {
        $payload=Outbox::getOutbox($limit);
        $data = array('username' => NITEXT_USERNAME,'password' => NITEXT_PASSWORD,'oa' =>SENDER_NAME,'payload' => json_encode($payload));
        $data = http_build_query($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => NITEXTSMSURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: ".NITEXT_COOKIE
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }
    public static function jambobetBatch($limit)
    {
        $postData=Outbox::getOutbox($limit);
        $postData=json_encode($postData);
        $headers=array(
            'Content-Type: application/json',
            'Authorization:'.API_TOKEN
        );
        $url=BATCH_URL;
		Myhelper::curlPost($postData,$headers,$url);
        
    }
    public static function sendOutbox($id)
    {
        $outbox=Outbox::findOne($id);
        $sentsms=new SentSms();
        $sentsms->receiver=$outbox->receiver;
        $sentsms->sender=$outbox->sender;
        $sentsms->message=$outbox->message;
        $sentsms->created_date=$outbox->created_date;
        $sentsms->category=$outbox->category;
        $sentsms->save(false);
        $outbox->delete(false);
        #handle coke&net,dev and cotz
        $hostname=gethostname();
        if(in_array($hostname,[COMP21_COKE,COMP21_NET]))
        {
            Outbox::niTextSms($sentsms);
        }
        if(in_array($hostname,[COMP21_DEV]))
        {
            Outbox::jambobetSms($sentsms->receiver,$sentsms->message,$sentsms->sender);
        }
        if(in_array($hostname,COTZ))
        {
            $channel=Myhelper::getSmsChannel($sentsms->receiver);
            Myhelper::sendTzSms($sentsms->receiver,$sentsms->message,SENDER_NAME,$channel);
        }
        
                
    }
    public static function jambobetSms($receiver,$message,$sender)
    {
        $postData =  [
            [
                "msisdn"=> $receiver,
                'sender'=>$sender,
                "message"=>$message
            ]
        ];
        $postData=json_encode($postData);
        $headers=array(
            'Content-Type: application/json',
            'Authorization:'.API_TOKEN
        );
        $url=SMS_URL;
		Myhelper::curlPost($postData,$headers,$url);
    }
    public static function niTextSms($sms)
    {
        $row=[
            "msisdn"=>(int)$sms->receiver,
            "message"=>$sms->message,
            "unique_id"=>(int)$sms->id
        ];
        $payload=[$row];
        $data = array('username' => NITEXT_USERNAME,'password' => NITEXT_PASSWORD,'oa' => SENDER_NAME,'payload' => json_encode($payload));
        $data = http_build_query($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => NITEXTSMSURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: ".NITEXT_COOKIE
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }
}
