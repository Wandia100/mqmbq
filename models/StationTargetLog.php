<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_target_log".
 *
 * @property int $id
 * @property string|null $station_name
 * @property string|null $station_id
 * @property string|null $range_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $target
 * @property int|null $achieved
 * @property int|null $diff
 * @property string $created_at
 */
class StationTargetLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_target_log';
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
            [['range_date','created_at'], 'safe'],
            [['target', 'achieved', 'diff'], 'integer'],
            [['start_time', 'end_time'], 'string','max'=>2],
            [['station_name'], 'string', 'max' => 50],
            [['station_id'], 'string', 'max' => 36],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_name' => 'Station Name',
            'station_id' => 'Station ID',
            'range_date' => 'Range Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'target' => 'Target',
            'achieved' => 'Achieved',
            'diff' => 'Diff',
            'created_at' => 'Created At',
        ];
    }
}
