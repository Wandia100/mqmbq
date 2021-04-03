<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_histories".
 *
 * @property string $id
 * @property string $mpesa_payment_id
 * @property string $reference_name
 * @property string $reference_phone
 * @property string $reference_code
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property float $amount
 * @property float $commission
 * @property int $status
 * @property int $is_archived
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class TransactionHistories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_histories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mpesa_payment_id', 'reference_name', 'reference_phone', 'reference_code'], 'required'],
            [['amount', 'commission'], 'number'],
            [['status', 'is_archived'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['mpesa_payment_id', 'reference_name', 'reference_phone', 'reference_code', 'station_show_id'], 'string', 'max' => 255],
            [['station_id'], 'string', 'max' => 100],
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
            'mpesa_payment_id' => 'Mpesa Payment ID',
            'reference_name' => 'Reference Name',
            'reference_phone' => 'Reference Phone',
            'reference_code' => 'Reference Code',
            'station_id' => 'Station ID',
            'station_show_id' => 'Station Show ID',
            'amount' => 'Amount',
            'commission' => 'Commission',
            'status' => 'Status',
            'is_archived' => 'Is Archived',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
