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
 * @property int $status
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
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStations() {
        return $this->hasOne(Stations::className(), [ 'id' => 'station_id' ] );
    }
    
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getMpesapayment() {
        return $this->hasOne(MpesaPayments::className(), ['id' => 'mpesa_payment_id']);
    }
    
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStationshows(){
        return $this->hasOne(StationShows::className(), ['id' => 'station_show_id']);
    }
    /**
     * Getter for users full name
     * @return string
     */
    public function getMpesadetails() {
        if (isset($this->mpesapayment->TransID)){
            return $this->mpesapayment->TransID.' '.$this->mpesapayment->BillRefNumber;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mpesa_payment_id', 'reference_name', 'reference_phone', 'reference_code'], 'required'],
            [['amount'], 'number'],
            [['status'], 'integer'],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getShowTransactions($station_show_id,$start_time,$end_time)
    {
        $sql="SELECT reference_name,reference_phone,amount,created_at FROM transaction_histories 
        WHERE station_show_id=:station_show_id
        AND deleted_at IS NULL AND created_at BETWEEN :start_time AND :end_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':start_time',$start_time)
        ->bindValue(':end_time',$end_time)
        ->queryAll();
    }
    public static function getTransactionTotal($station_show_id,$start_time,$end_time)
    {
        $sql="SELECT coalesce(sum(amount),0) as total FROM transaction_histories 
        WHERE station_show_id=:station_show_id
        AND deleted_at IS NULL AND created_at BETWEEN :start_time AND :end_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':start_time',$start_time)
        ->bindValue(':end_time',$end_time)
        ->queryOne();
    }
    public static function pickRandom($station_show_id,$past_winners,$from_date)
    {
        $sql="SELECT * FROM transaction_histories WHERE station_show_id=:station_show_id AND created_at >:from_date AND reference_phone NOT IN (" . implode(',', $past_winners) . ") ORDER BY RAND() LIMIT 1";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':from_date',$from_date)
        ->queryOne();
    }
    public static function getTotalTransactions($from_time)
    {
        $sql="select COALESCE(sum(amount),0) as total_history from 
        transaction_histories where created_at LIKE :from_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryOne();
    }
    public static function getTotalTransactionsInRange($from_time,$to_time)
    {
        $sql="select COALESCE(sum(amount),0) as total_history from 
        transaction_histories where created_at >= :from_time and
        created_at <= :to_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->queryOne();
    }
    public static function getDuplicates()
    {
        $sql='SELECT COUNT(mpesa_payment_id) AS total,mpesa_payment_id FROM transaction_histories  GROUP BY mpesa_payment_id HAVING(total > 1)';
        return Yii::$app->db->createCommand($sql)
        ->queryAll();
    }
    public static function removeDups($unique_field,$limits)
    {
        $sql='DELETE FROM transaction_histories WHERE mpesa_payment_id=:mpesa_payment_id LIMIT :limits';
        Yii::$app->db->createCommand($sql)
        ->bindValue(':mpesa_payment_id',$unique_field)
        ->bindValue(':limits',$limits)
        ->execute();
    }
    public static function countEntry($phone_number)
    {
        return TransactionHistories::find()->where("reference_phone='$phone_number'")->count();
    }
    public static function generateEntryNumber($phone_number,$entry_count)
    {
        return $entry_count.substr($phone_number,3);
    }
}
