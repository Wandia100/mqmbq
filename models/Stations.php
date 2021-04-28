<?php

namespace app\models;
use app\models\MpesaPayments;

use Yii;

/**
 * This is the model class for table "stations".
 *
 * @property string $id
 * @property string $name
 * @property string|null $address
 * @property int $enabled
 * @property string $station_code
 * @property float $invalid_percentage
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Stations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'station_code'], 'required'],
            [['enabled'], 'integer'],
            [['invalid_percentage'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['name', 'address'], 'string', 'max' => 255],
            [['station_code'], 'string', 'max' => 100],
            [['station_code'], 'unique'],
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
            'name' => 'Name',
            'address' => 'Address',
            'enabled' => 'Enabled',
            'station_code' => 'Station Code',
            'invalid_percentage' => 'Invalid Percentage',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    /**
     * Method to getPermission group list
     * @return type
     */
    public static function getStations(){
        $list = [];
        $records = Stations::findAll(['enabled'=>1]);
        foreach ($records as $record) {
            $list[$record -> id] = $record->name;
        }
        return $list;
    }
    public static function getStationResult($from_time)
    {
        $response=array();
        $sql="select a.id,a.id as station_id,a.name as station_name,a.name,a.station_code from stations a where a.deleted_at IS NULL order by a.name asc";
        $data= Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryAll();
        for($i=0;$i<count($data); $i++)
        {
            $row=$data[$i];
            $row['amount']=MpesaPayments::getStationTotalMpesa($from_time,$row['name'])['amount'];
            array_push($response,$row);

        }
        return $response;
    }
    public static function getStationTotalResult($start_period,$end_period)
    {
        $sql="select a.id,a.id as station_id,a.name as station_name,a.station_code,
        COALESCE((select sum(b.TransAmount) from mpesa_payments b where b.deleted_at IS NULL AND b.created_at >= :start_period and
        b.created_at <= :end_period AND b.BillRefNumber=a.name),0) as amount from stations a where a.deleted_at IS NULL order by a.name asc";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_period',$start_period)
        ->bindValue(':end_period',$end_period)
        ->queryAll();
    }
    public static function getDayStationTotalResult($the_day)
    {
        $sql="select a.id,a.id as station_id,a.name as station_name,a.station_code,
        COALESCE((select sum(b.TransAmount) from mpesa_payments b where b.deleted_at IS NULL AND b.created_at LIKE :the_day  AND b.BillRefNumber=a.name),0) as amount from stations a where a.deleted_at IS NULL order by a.name asc";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':the_day',"%$the_day%")
        ->queryAll();
    }
    public static function getActiveStations()
    {
        return Stations::find()->where("deleted_at is null")->orderBy("name asc")->all();
    }
}
