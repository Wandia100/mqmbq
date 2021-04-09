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
}
