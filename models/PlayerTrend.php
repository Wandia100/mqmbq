<?php

namespace app\models;

use Yii;

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
            [['station_id'], 'string', 'max' => 36],
            [['station', 'unique_field'], 'string', 'max' => 50],
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
            'station_id' => 'Station ID',
            'station' => 'Station',
            'frequency' => 'Frequency',
            'hour_date' => 'Hour Date',
            'unique_field' => 'Unique Field',
            'created_at' => 'Created At',
        ];
    }
}
