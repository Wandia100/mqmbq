<?php

namespace app\models;

use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "sent_sms".
 *
 * @property int $id
 * @property string|null $receiver
 * @property string|null $sender
 * @property string|null $message
 * @property string $created_date
 * @property int $category
 */
class SentSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sent_sms';
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
            [['category'], 'integer'],
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
            'category' => 'Category',
        ];
    }
    public static function archive($created_at,$limit)
    {
        $data=SentSms::find()->where("created_date < '$created_at'")->limit($limit)->all();
        $rows="";
        $length=count($data);
        $sql="INSERT INTO `sent_sms` (`id`, `receiver`, `sender`, `message`,`created_date`) VALUES ";
        for($i=0;$i<$length;$i++)
        {
            $row=$data[$i];
            $message=str_replace("'","",$row->message);
            $sql.="('$row->id','$row->receiver','$row->sender','message','$row->created_date')";
            $rows.="'".$row->id."'";
            if($i!=$length-1)
            {
                $rows.=",";
                $sql.=",";
            }
        }
        $sql.=" ON DUPLICATE KEY UPDATE id=id;";
        if(strlen($rows) > 0)
        {
            Yii::$app->analytics_db->createCommand($sql)->execute();
            Yii::$app->sms_db->createCommand("DELETE FROM sent_sms  WHERE id IN ($rows)")->execute();
        }
        
        

    }    
}
