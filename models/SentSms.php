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
    public static function archive($created_date)
    {
        $data=SentSms::find()->where("created_date like '%$created_date%'")->all();
        foreach($data as $row)
        {
            try
            {
                $model=new ArchivedSentSms();
                $model->id=$row->id;
                $model->receiver=$row->receiver;
                $model->sender=$row->sender;
                $model->message=$row->message;
                $model->created_date=$row->created_date;
                $model->save(false);
            }
            catch(IntegrityException $e)
            {}
            $row->delete(false);
        }

    }
}
