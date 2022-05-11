<?php

namespace app\models;

use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property string|null $station
 * @property string|null $station_show
 * @property string|null $msisdn
 * @property float|null $amount
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['station_id', 'station_show_id', 'created_by'], 'string', 'max' => 36],
            [['station', 'station_show'], 'string', 'max' => 50],
            [['msisdn'], 'string', 'max' => 12],
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
            'station' => 'Station',
            'station_show' => 'Station Show',
            'msisdn' => 'Msisdn',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
    public static function distinctWinners($stationId,$frequency,$startDate)
    {
        $sql="SELECT DISTINCT(msisdn) AS phone FROM bonus WHERE station_id=:stationId AND created_at > DATE_SUB(:startDate, INTERVAL :frequency DAY)";
        $data=Yii::$app->db->createCommand($sql)
        ->bindValue(':stationId',$stationId)
        ->bindValue(':frequency',$frequency)
        ->bindValue(':startDate',$startDate)
        ->queryAll();
        $arr=[];
        for($i=0;$i < count($data); $i++)
        {
            $arr[$i]=$data[$i]['phone'];

        }
        return $arr;
    }
    public static function saveBonus($id,$station_id,$station_show_id,$station,$station_show,$msisdn,$amount,$created_by)
    {
        try{
            $model=new Bonus();
            $model->id=$id;
            $model->station_id=$station_id;
            $model->station_show_id=$station_show_id;
            $model->station=$station;
            $model->station_show=$station_show;
            $model->msisdn=$msisdn;
            $model->amount=$amount;
            $model->created_at=date('Y-m-d H:i:s');
            $model->created_by=$created_by;
            $model->save(false);
        }
        catch(IntegrityException $e)
        {
            //do nothing for now
        }
    }
    public static function getRecentWinners($station_show_id,$today)
    {
        $sql="SELECT station,station_show,msisdn,amount,created_at FROM bonus  WHERE 
        station_show_id=:station_show_id AND created_at >:today";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->bindValue(':today',$today)
        ->queryAll();
    }
}
