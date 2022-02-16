<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_shows".
 *
 * @property string $id
 * @property string $station_id
 * @property string $name
 * @property string|null $description
 * @property string $show_code
 * @property float $amount
 * @property float $commission
 * @property float $management_commission
 * @property float $price_amount
 * @property float $target
 * @property int $draw_count
 * @property float $invalid_percentage
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property int $sunday
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class StationShows extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_shows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'name', 'show_code','monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'start_time', 'end_time', 'enabled'], 'required'],
            [['description'], 'string'],
            [['target', 'invalid_percentage'], 'number'],
            [['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'enabled'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'name', 'show_code', 'start_time', 'end_time'], 'string', 'max' => 255],
            [['show_code'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
        *   Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStations() {
        return $this->hasOne(Stations::className(), [ 'id' => 'station_id' ] );
    }
    public static function getStationShows() {
        $arr   = [];
        $model = StationShows::find()->orderBy("name ASC")->all();
        foreach ( $model as $value ) {
            $arr[ $value->id ] = $value->name;
        }
        return $arr;
   }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'name' => 'Name',
            'description' => 'Description',
            'show_code' => 'Show Code',
            'target' => 'Target',
            'invalid_percentage' => 'Invalid Percentage',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
            'start_time' => 'Start Time(HH:mm)',
            'end_time' => 'End Time(HH:mm)',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getStationShow($stat_code)
    {
        $scode=$stat_code;
        $current_day=strtolower(date("l"));
        $sql="SELECT a.name,a.station_code,b.station_id,b.id AS show_id,b.start_time,b.end_time FROM stations a 
        LEFT JOIN station_shows b ON a.id=b.station_id  WHERE b.enabled=1 AND b.deleted_at IS NULL AND 
        a.deleted_at IS NULL AND  (SUBSTRING(a.station_code,1,3)=SUBSTRING(:stat_code,1,3) || RIGHT(a.station_code,3)=RIGHT(:stat_code,3) || a.station_code LIKE :scode) 
        AND b.".$current_day."=1  AND start_time <= CURRENT_TIME()  AND end_time >=CURRENT_TIME();";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':stat_code',$stat_code)
        ->bindValue(':scode',"%$scode%")
        ->queryOne();
    }
    public static function getStationShowNet($stat_code)
    {
        $current_day=strtolower(date("l"));
        $sql="SELECT a.name,a.station_code,b.station_id,b.id AS show_id,b.start_time,b.end_time FROM stations a 
        LEFT JOIN station_shows b ON a.id=b.station_id  WHERE b.enabled=1 AND b.deleted_at IS NULL AND 
        a.deleted_at IS NULL AND a.station_code=:stat_code AND b.".$current_day."=1  AND start_time <= CURRENT_TIME()  AND end_time >=CURRENT_TIME();";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':stat_code',$stat_code)
        ->queryOne();
    }
    public static function getStationShowSummary($start_date,$end_date)
    {
        $sql="SELECT a.id,a.station_id,a.name AS station_show_name,b.name AS station_name,
        COALESCE((SELECT SUM(amount) FROM transaction_histories WHERE station_show_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_revenue,
        COALESCE((SELECT SUM(amount) FROM commissions WHERE station_show_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_commission,
        COALESCE((SELECT SUM(amount) FROM winning_histories WHERE station_show_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_payout
         FROM station_shows a LEFT JOIN stations b ON a.station_id=b.id 
         WHERE a.deleted_at IS NULL AND a.enabled=1 ORDER BY total_revenue DESC";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    public static function getShowForCommission($current_day)
    {
        $sql="SELECT * FROM station_shows WHERE ".$current_day."=1 AND enabled=1 AND deleted_at IS NULL AND end_time < CURRENT_TIME()";
        return Yii::$app->db->createCommand($sql)
        ->queryAll();

    }
    public static function getMidnightShow($current_day)
    {
        $sql="SELECT * FROM station_shows WHERE ".$current_day."=1 AND enabled=1 AND deleted_at IS NULL AND end_time > '23:30'  AND end_time <= '23:59'";
        return Yii::$app->db->createCommand($sql)
        ->queryAll();

    }
}
