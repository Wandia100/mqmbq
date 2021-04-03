<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_show_prizes".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property string|null $prize_id
 * @property int $draw_count
 * @property float $amount
 * @property int $enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class StationShowPrizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_show_prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['draw_count', 'enabled'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'station_show_id', 'prize_id'], 'string', 'max' => 255],
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
            'station_show_id' => 'Station Show ID',
            'prize_id' => 'Prize ID',
            'draw_count' => 'Draw Count',
            'amount' => 'Amount',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
