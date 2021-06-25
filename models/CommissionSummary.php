<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commission_summary".
 *
 * @property int $id
 * @property string|null $station_name
 * @property string|null $show_name
 * @property string|null $show_timing
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property int|null $target
 * @property int|null $achieved
 * @property int|null $payout
 * @property int|null $net_revenue
 * @property int|null $presenter_commission
 * @property int|null $station_commission
 * @property string|null $commission_date
 */
class CommissionSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commission_summary';
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
            [['target', 'achieved', 'payout', 'net_revenue', 'presenter_commission', 'station_commission'], 'integer'],
            [['commission_date'], 'safe'],
            [['station_name'], 'string', 'max' => 50],
            [['show_name'], 'string', 'max' => 100],
            [['show_timing'], 'string', 'max' => 25],
            [['station_id', 'station_show_id'], 'string', 'max' => 36],
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
            'show_name' => 'Show Name',
            'show_timing' => 'Show Timing',
            'station_id' => 'Station ID',
            'station_show_id' => 'Station Show ID',
            'target' => 'Target',
            'achieved' => 'Achieved',
            'payout' => 'Payout',
            'net_revenue' => 'Net Revenue',
            'presenter_commission' => 'Presenter Commission',
            'station_commission' => 'Station Commission',
            'commission_date' => 'Commission Date',
        ];
    }
}
