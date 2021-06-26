<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "show_summary".
 *
 * @property int $id
 * @property string|null $station_show_id
 * @property int|null $total_revenue
 * @property int|null $total_commission
 * @property int|null $total_payouts
 * @property string|null $report_date
 * @property string $created_at
 */
class ShowSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'show_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total_revenue', 'total_commission', 'total_payouts'], 'integer'],
            [['report_date', 'created_at'], 'safe'],
            [['station_show_id','station_name','station_show_name'], 'string', 'max' => 50],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_show_id' => 'Station Show ID',
            'total_revenue' => 'Total Revenue',
            'total_commission' => 'Total Commission',
            'total_payouts' => 'Total Payouts',
            'report_date' => 'Report Date',
            'created_at' => 'Created At',
        ];
    }
    public static function checkDuplicate($report_date)
    {
        return ShowSummary::find()->where("report_date=:report_date",[':report_date' => $report_date])->count();
    }
    public static function getShowSummary($start_date,$end_date)
    {
        $sql="SELECT station_name,station_show_name,COALESCE(SUM(total_revenue),0) AS revenue,COALESCE(SUM(total_commission),0) AS commission,
        COALESCE(SUM(total_payouts),0) AS payout FROM show_summary WHERE report_date BETWEEN  :start_date AND :end_date GROUP BY station_show_id,station_name,station_show_name ORDER BY 
        revenue DESC";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
}
