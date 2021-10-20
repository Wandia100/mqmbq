<?php

namespace app\models;

use Yii;

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
            [['start_time', 'end_time'], 'safe'],
            [['target'], 'integer'],
            [['station_id'], 'string', 'max' => 36],
            [['unique_field'], 'string', 'max' => 50],
        ];
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
}
