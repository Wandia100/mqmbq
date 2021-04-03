<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hourly_performance_reports".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $hour
 * @property float $amount
 * @property float $invalid_codes
 * @property float $total_amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class HourlyPerformanceReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hourly_performance_reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['amount', 'invalid_codes', 'total_amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'hour'], 'string', 'max' => 255],
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
            'hour' => 'Hour',
            'amount' => 'Amount',
            'invalid_codes' => 'Invalid Codes',
            'total_amount' => 'Total Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
