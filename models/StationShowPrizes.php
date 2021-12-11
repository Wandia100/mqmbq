<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_show_prizes".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property int $draw_count
 * @property int $enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class StationShowPrizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_show_prizes';
    }

    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getMondayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'monday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getTuesdayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'tuesday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getWednesdayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'wednesday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getThursdayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'thursday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getFridayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'friday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getSaturdayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'saturday' ] );
    }
    /**
        *   prize relationship
        * @return \yii\db\ActiveQuery
    */
    public function getSundayprize() {
        return $this->hasOne(Prizes::className(), [ 'id' => 'sunday' ] );
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['draw_count', 'enabled'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'station_show_id'], 'string', 'max' => 255],
            [['monday', 'tuesday', 'wednesday','thursday','friday','sunday','saturday'], 'string', 'max' => 255],
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
            'station_id' => 'Station ID',
            'station_show_id' => 'Station Show ID',
            'draw_count' => 'Draw Count',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getShowPrizes($current_day,$station_show_id,$from_date)
    {
        $sql="SELECT a.draw_count,a.".$current_day." as prize_id,b.amount,b.name,b.description,a.enabled,
        (SELECT COUNT(id) FROM winning_histories WHERE station_show_id=:station_show_id AND station_show_prize_id=
        a.".$current_day." AND created_at >:from_date) AS prizes_given FROM station_show_prizes a  LEFT JOIN prizes b ON a.".$current_day."=b.id 
        WHERE station_show_id=:station_show_id AND a.enabled=1 HAVING (a.draw_count > prizes_given)";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':from_date',$from_date)
        ->queryAll();

    }
    public static function getShowPrize($current_day,$station_show_id,$prize_id,$from_date)
    {
        $sql="SELECT a.draw_count,b.mpesa_disbursement,b.disbursable_amount,a.".$current_day." as prize_id,b.amount,b.name,b.description,a.enabled,b.enable_tax,b.tax,
        (SELECT COUNT(id) FROM winning_histories WHERE station_show_id=:station_show_id AND station_show_prize_id=
        a.".$current_day." AND created_at >:from_date) AS prizes_given FROM station_show_prizes a  LEFT JOIN prizes b ON a.".$current_day."=b.id 
        WHERE station_show_id=:station_show_id AND b.id=:prize_id AND a.enabled=1 HAVING (a.draw_count > prizes_given)";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':prize_id',$prize_id)
        ->bindValue(':from_date',$from_date)
        ->queryOne();

    }
}
