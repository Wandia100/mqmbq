<?php

namespace app\models;

use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "player_trend".
 *
 * @property int $id
 * @property string|null $msisdn
 * @property string|null $hour
 * @property string|null $station_id
 * @property string|null $station
 * @property int|null $frequency
 * @property string|null $hour_date
 * @property string|null $unique_field
 * @property string $created_at
 */
class PlayerTrend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'player_trend';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('analytics_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['hour_date', 'created_at'], 'safe'],
            [['msisdn'], 'string', 'max' => 12],
            [['hour'], 'string', 'max' => 2],
            [['station', 'unique_field','station_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msisdn' => 'Msisdn',
            'hour' => 'Hour',
            'station' => 'Station',
            'frequency' => 'Frequency',
            'hour_date' => 'Hour Date',
            'unique_field' => 'Unique Field',
            'created_at' => 'Created At',
        ];
    }
    public static function logTrend()
    {
        $created_at=date("Y-m-d");
        $hour=date("H",strtotime("- 1 hour"));
        $data=MpesaPayments::getPlayerTrend($created_at." ".$hour);
        for($i=0; $i< count($data); $i++)
        {
            try
            {
                $model=new PlayerTrend();
                $model->msisdn=$data[$i]['msisdn'];
                $model->frequency=$data[$i]['frequency'];
                $model->hour=$hour;
                $model->station=$data[$i]['station'];
                $model->hour_date=$created_at;
                $model->station_id=$data[$i]['station_id'];
                $model->unique_field=$created_at.$hour.$model->station.$model->msisdn;
                $model->save(false);
            }
            catch(IntegrityException $e)
            {
                //do nothing
            }
        }
    }
}
