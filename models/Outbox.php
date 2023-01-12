<?php

namespace app\models;

use Yii;
use app\components\Myhelper;
use Webpatser\Uuid\Uuid;

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
            [['created_date','id'], 'safe'],
            [['status', 'category'], 'integer'],
            [['receiver', 'sender'], 'string', 'max' => 20],
            [['station_id'], 'string', 'max' => 50],
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
    public static function tzOutbox($limit)
    {
        return Outbox::find()->limit($limit)->all();
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
        if($outbox==NULL)
        {
            return;
        }
        $sentsms=new SentSms();
        $sentsms->id=Uuid::generate()->string;
        $sentsms->receiver=$outbox->receiver;
        $sentsms->sender=$outbox->sender;
        $sentsms->message=$outbox->message;
        $sentsms->station_id=$outbox->station_id;
        $sentsms->created_date=$outbox->created_date;
        $sentsms->category=$outbox->category;
        $sentsms->save(false);
        $outbox->delete(false);
        $channel=Myhelper::getSmsChannel($sentsms->receiver);
        if(gethostname()!='kuta')
        {
            Myhelper::sendTzSms($sentsms->receiver,$sentsms->message,SENDER_NAME,$channel,$sentsms->id);
        }
        
        
                
    }
    public static function zambiaSms($id,$message,$receiver)
    {
        $postData =  [
            [
                "id"=> $id,
                "message"=>$message,
                'receiver'=>$receiver
            ]
        ];
        $postData=json_encode($postData);
        $headers=array(
            'Content-Type: application/json',
            'Authorization:'.SMPP_TOKEN
        );
        $url=SMS_URL;
		Myhelper::curlPost($postData,$headers,$url);
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
        return $response;
    }
    public static function getDuplicates()
    {
        $sql='SELECT COUNT(receiver) AS total,receiver FROM outbox  GROUP BY receiver HAVING(total > 1) order by total desc limit 1000';
        return Yii::$app->sms_db->createCommand($sql)
        ->queryAll();
    }
    public static function removeDups($unique_field,$limits)
    {
        $sql="DELETE FROM outbox WHERE receiver=$unique_field LIMIT $limits;";
        echo $sql;
        //Yii::$app->sms_db->createCommand($sql)->bindValue(':receiver',$unique_field)->bindValue(':limits',$limits)->execute();
    }
}
