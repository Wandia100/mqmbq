<?php

namespace app\models;

use Yii;

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
    public static function getOutbox()
    {
        $smses=Outbox::find()->limit(200)->all();
        $pending=[];
        for($i=0;$i <count($smses); $i++)
        {
            $sms=$smses[$i];
            $pen=[
                "msisdn"=>(int)$sms->receiver,
                "message"=>$sms->message,
                "unique_id"=>(int)$sms->id
            ];
            array_push($pending,$pen);
            $sms->delete(false);
            $sent_sms=new SentSms();
            $sent_sms->receiver=$sms->receiver;
            $sent_sms->message=$sms->message;
            $sent_sms->category=$sms->category;
            $sent_sms->category=$sms->category;
            $sent_sms->created_date=$sms->created_date;
            $sent_sms->save(false);
        }
        return $pending;
    }
    public static function insertBulk($message,$sender)
    {
        $sql="INSERT INTO outbox (receiver,sender,message,status)
        (SELECT DISTINCT(receiver),'DEFAULT','".$message."','1' FROM sent_sms)";
        return Yii::$app->sms_db->createCommand($sql)
        ->execute();
    }
}
