<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winner_summary".
 *
 * @property int $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property string|null $station_name
 * @property string|null $show_name
 * @property string|null $prize_name
 * @property string|null $prize_id
 * @property string|null $show_timing
 * @property int|null $awarded
 * @property string|null $winning_date
 * @property string|null $unique_field
 */
class WinnerSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winner_summary';
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
            [['awarded'], 'integer'],
            [['winning_date'], 'safe'],
            [['station_id', 'station_show_id', 'prize_id'], 'string', 'max' => 36],
            [['station_name', 'prize_name'], 'string', 'max' => 50],
            [['show_name'], 'string', 'max' => 50],
            [['show_timing'], 'string', 'max' => 25],
            [['unique_field'], 'string', 'max' => 500],
            [['unique_field'], 'unique'],
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
            'station_name' => 'Station Name',
            'show_name' => 'Show Name',
            'prize_name' => 'Prize Name',
            'prize_id' => 'Prize ID',
            'show_timing' => 'Show Timing',
            'awarded' => 'Awarded',
            'winning_date' => 'Winning Date',
            'unique_field' => 'Unique Field',
        ];
    }
}
