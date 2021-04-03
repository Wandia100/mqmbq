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
            [['id', 'station_id', 'name', 'show_code'], 'required'],
            [['description'], 'string'],
            [['amount', 'commission', 'management_commission', 'price_amount', 'target', 'invalid_percentage'], 'number'],
            [['draw_count', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'enabled'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'name', 'show_code', 'start_time', 'end_time'], 'string', 'max' => 255],
            [['show_code'], 'unique'],
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
            'name' => 'Name',
            'description' => 'Description',
            'show_code' => 'Show Code',
            'amount' => 'Amount',
            'commission' => 'Commission',
            'management_commission' => 'Management Commission',
            'price_amount' => 'Price Amount',
            'target' => 'Target',
            'draw_count' => 'Draw Count',
            'invalid_percentage' => 'Invalid Percentage',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
