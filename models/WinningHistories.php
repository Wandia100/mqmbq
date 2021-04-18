<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winning_histories".
 *
 * @property string $id
 * @property string|null $prize_id
 * @property string|null $station_show_prize_id
 * @property string $reference_name
 * @property string $reference_phone
 * @property string $reference_code
 * @property string|null $station_id
 * @property string|null $presenter_id
 * @property string|null $station_show_id
 * @property float $amount
 * @property float $transaction_cost
 * @property string|null $conversation_id
 * @property string|null $transaction_reference
 * @property int $status
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class WinningHistories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winning_histories';
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
    public function getStationshows(){
        return $this->hasOne(StationShows::className(), ['id' => 'station_show_id']);
    }

    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getPrizes() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'prize_id' ] );
    }
    
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStationshowprize() {
        return $this->hasOne(StationShowPrizes::className(), [ 'id' => 'station_show_prize_id' ] );
    }
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getPresenter() {
        return $this->hasOne(Users::className(), [ 'id' => 'presenter_id' ] );
    }
    
    
    /**
     * Getter for users full name
     * @return string
     */
    public function getFullname() {
        if ( isset( $this->presenter->first_name ) && isset( $this->presenter->last_name ) ) {
                return $this->presenter->first_name . " " . $this->presenter->last_name;
        } elseif ( isset( $this->presenter->first_name ) ) {
                return $this->presenter->first_name;
        } elseif ( isset( $this->presenter->last_name ) ) {
            return $this->presenter->last_name;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reference_name', 'reference_phone', 'reference_code'], 'required'],
            [['amount', 'transaction_cost'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['prize_id', 'station_show_prize_id', 'conversation_id', 'transaction_reference', 'remember_token'], 'string', 'max' => 100],
            [['reference_name', 'reference_phone', 'reference_code', 'station_id', 'presenter_id', 'station_show_id'], 'string', 'max' => 255],
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
            'prize_id' => 'Prize ID',
            'station_show_prize_id' => 'Station Show Prize ID',
            'reference_name' => 'Reference Name',
            'reference_phone' => 'Reference Phone',
            'reference_code' => 'Reference Code',
            'station_id' => 'Station ID',
            'presenter_id' => 'Presenter ID',
            'station_show_id' => 'Station Show ID',
            'amount' => 'Amount',
            'transaction_cost' => 'Transaction Cost',
            'conversation_id' => 'Conversation ID',
            'transaction_reference' => 'Transaction Reference',
            'status' => 'Status',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'stationshowprizeamount' => 'Prizeamount',
            'stationshowname' => 'Showname',
            'stationname' => 'Station'
        ];
    }
    public static function getRecentWinners($station_show_id,$today)
    {
        $sql="SELECT reference_name,reference_code,amount,created_at FROM winning_histories WHERE 
        station_show_id=:station_show_id AND created_at >:today";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':today',$today)
        ->queryAll();
    }
    public static function getDayPayout($station_show_id,$the_day)
    {
        $sql="SELECT COALESCE(SUM(amount),0) AS total FROM winning_histories station_show_id=:station_show_id
        AND created_at LIKE :the_day";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':the_day',"%$today%")
        ->queryOne();
    }
}
