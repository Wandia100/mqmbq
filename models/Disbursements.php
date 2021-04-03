<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disbursements".
 *
 * @property string $id
 * @property string|null $reference_id
 * @property string|null $reference_name
 * @property string|null $phone_number
 * @property float $amount
 * @property string|null $conversation_id
 * @property int $status
 * @property string|null $disbursement_type
 * @property string|null $transaction_reference
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Disbursements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disbursements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['amount'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['reference_id', 'disbursement_type', 'transaction_reference'], 'string', 'max' => 100],
            [['reference_name', 'phone_number', 'conversation_id'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Reference ID',
            'reference_name' => 'Reference Name',
            'phone_number' => 'Phone Number',
            'amount' => 'Amount',
            'conversation_id' => 'Conversation ID',
            'status' => 'Status',
            'disbursement_type' => 'Disbursement Type',
            'transaction_reference' => 'Transaction Reference',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
