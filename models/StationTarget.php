<?php

namespace app\models;

use Yii;
use app\models\HourlyPerformanceReports;
use app\models\StationTargetLog;
use yii\db\IntegrityException;
/**
 * This is the model class for table "station_target".
 *
 * @property int $id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $station_id
 * @property int|null $target
 * @property string|null $unique_field
 */
class StationTarget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_target';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time'], 'string','max'=>2],
            [['target'], 'integer'],
            [['station_id'], 'string', 'max' => 36],
            [['unique_field'], 'string', 'max' => 50],
        ];
    }
    /**
        *   Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStations() {
        return $this->hasOne(Stations::className(), [ 'id' => 'station_id' ] );
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'station_id' => 'Station ID',
            'target' => 'Target',
            'unique_field' => 'Unique Field',
        ];
    }
    public static function getTargets($start_time)
    {
        $sql="SELECT a.id,a.start_time,a.end_time,b.name AS station_name,a.target,a.station_id
        FROM station_target a LEFT JOIN stations b ON a.station_id=b.id WHERE a.start_time >=:start_time AND a.end_time > :start_time";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_time',$start_time)
        ->queryAll();
    }
    public static function setTargetLog($hour,$hour_date)
    {
        $data=StationTarget::getTargets($hour);
        for($i=0; $i<count($data); $i++)
        {
            $start_time=$data[$i]['start_time'];
            $end_time=$data[$i]['end_time'];
            $target=$data[$i]['target'];
            $station_id=$data[$i]['station_id'];
            $station_target_id=$data[$i]['id'];
            $unique_field=$station_target_id.$hour_date;
            $achieved=HourlyPerformanceReports::getRangeTotal($start_time,$end_time,$hour_date,$station_id);
            //var_dump($achieved); exit();
            //check if exists
            $model=StationTargetLog::find()->where(['unique_field'=>$unique_field])->one();
            if($model==NULL)
            {
                try{
                    $model=new StationTargetLog();
                    $model->station_name=$data[$i]['station_name'];
                    $model->station_id=$station_id;
                    $model->range_date=$hour_date;
                    $model->station_target_id=$station_target_id;
                    $model->start_time=$start_time;
                    $model->end_time=$end_time;
                    $model->target=$target;
                    $model->achieved=$achieved;
                    $model->diff=round($target-$achieved);
                    $model->unique_field=$unique_field;
                    $model->save(false);
                }
                catch(IntegrityException $e)
                {
                    //do nothing
                }
            }
            else
            {
               
                $model->target=$target;
                $model->achieved=$achieved;
                $model->diff=round($target-$achieved);
                $model->save(false);

            }
            
            
        }
    }
}
