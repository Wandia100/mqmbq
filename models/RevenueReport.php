<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "revenue_report".
 *
 * @property int $id
 * @property string|null $revenue_date
 * @property int|null $total_revenue
 * @property int|null $total_awarded
 * @property int|null $net_revenue
 */
class RevenueReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'revenue_report';
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
            [['revenue_date'], 'safe'],
            [['total_revenue', 'total_awarded', 'net_revenue'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'revenue_date' => 'Revenue Date',
            'total_revenue' => 'Total Revenue',
            'total_awarded' => 'Total Awarded',
            'net_revenue' => 'Net Revenue',
        ];
    }
}
