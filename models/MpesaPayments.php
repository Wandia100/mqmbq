<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mpesa_payments".
 *
 * @property string $id
 * @property string|null $TransID
 * @property string|null $FirstName
 * @property string|null $MiddleName
 * @property string|null $LastName
 * @property string|null $MSISDN
 * @property string|null $InvoiceNumber
 * @property string|null $BusinessShortCode
 * @property string|null $ThirdPartyTransID
 * @property string|null $TransactionType
 * @property string|null $OrgAccountBalance
 * @property string|null $BillRefNumber
 * @property string|null $TransAmount
 * @property int $is_archived
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class MpesaPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesa_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['is_archived'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['TransID', 'deleted_at'], 'string', 'max' => 100],
            [['FirstName', 'MiddleName', 'LastName', 'MSISDN', 'InvoiceNumber', 'BusinessShortCode', 'ThirdPartyTransID', 'TransactionType', 'OrgAccountBalance', 'BillRefNumber', 'TransAmount'], 'string', 'max' => 255],
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
            'TransID' => 'Trans ID',
            'FirstName' => 'First Name',
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'MSISDN' => 'Msisdn',
            'InvoiceNumber' => 'Invoice Number',
            'BusinessShortCode' => 'Business Short Code',
            'ThirdPartyTransID' => 'Third Party Trans ID',
            'TransactionType' => 'Transaction Type',
            'OrgAccountBalance' => 'Org Account Balance',
            'BillRefNumber' => 'Bill Ref Number',
            'TransAmount' => 'Trans Amount',
            'is_archived' => 'Is Archived',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getTotalMpesa($from_time)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments where created_at 
        LIKE :from_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryOne();
    }
    public static function getTotalMpesaInRange($from_time,$to_time)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from 
        mpesa_payments where created_at >= :from_time and
        created_at <= :to_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->queryOne();
    }
}
