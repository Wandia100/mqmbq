<?php

namespace app\models;

use Yii;

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
class ArchivedSentSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sent_sms';
    }
    public static function getDb() {
        return Yii::$app->analytics_db;
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
}
