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
            [['revenue_date','station_id','unique_field','station_name'], 'safe'],
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
            'station_name' => 'Station',
            'revenue_date' => 'Revenue Date',
            'total_revenue' => 'Total Revenue',
            'total_awarded' => 'Total Awarded',
            'net_revenue' => 'Net Revenue',
        ];
    }
    public static function getRevenueReport($start_date,$end_date)
    {
        $sql= RevenueReport::find()->where("revenue_date >= '$start_date'")->andWhere("revenue_date <='$end_date'");
        $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
            $stations = implode(",", array_map(function($string) {
               return '"' . $string . '"';
            }, \Yii::$app->myhelper->getStations()));
            $sql->andWhere("station_id IN ($stations)");
        }
        return $sql->all();
    }
    public static function checkDuplicate($unique_field)
    {
        return RevenueReport::find()->where("unique_field='$unique_field'")->one();
    }
    /**
     * Method to get monthly growth trend
     * @return type
     */
    public static function monthlyGrowthTrendData(){
        $sum = [];
        $range = [];
        $year = date('Y');
        for ($i = 1; $i <= 12; $i ++){
            $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
            $stations = implode(",", array_map(function($string) {
               return '"' . $string . '"';
            }, \Yii::$app->myhelper->getStations()));
            $data = RevenueReport::find()
                ->select(['total'=>'SUM(total_revenue)'])  
                ->where("MONTH(revenue_date)='$i'")
                ->andWhere("YEAR(revenue_date)='$year'")
                ->andWhere("station_id IN ($stations)")
                ->createCommand()->queryAll();
        }
        else
        {
            $data = RevenueReport::find()
                ->select(['total'=>'SUM(total_revenue)'])  
                ->where("MONTH(revenue_date)='$i'")
                ->andWhere("YEAR(revenue_date)='$year'")
                ->createCommand()->queryAll();
        }
            $sum[] = $data[0]['total'];
            $range[] = $i;
        }
        return  [ 'sum'=>$sum,'range' =>$range];
    }
    /**
     * 
     * @param type $start_date
     * @param type $end_date
     * @return type
     */
    public static function rangeGrowthTrendData($start_date,$end_date){
        $sum = [];
        $range = [];
        $year = date('Y');
        
        for ($i = $start_date; $i <= $end_date; $i = date('Y-m-d',strtotime('+1 day', strtotime($i)))){
             
                $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
            $stations = implode(",", array_map(function($string) {
               return '"' . $string . '"';
            }, \Yii::$app->myhelper->getStations()));
                $data = RevenueReport::find()
                ->select(['total'=>'SUM(total_revenue)'])  
                ->where("revenue_date ='$i'")
                ->andWhere("station_id IN ($stations)")
                ->createCommand()->queryAll();
        }
        else
        {
            $data = RevenueReport::find()
                ->select(['total'=>'SUM(total_revenue)'])  
                ->where("revenue_date ='$i'")
                ->createCommand()->queryAll();
        }
            $sum[] = $data[0]['total'] > 0 ? $data[0]['total']: 0;
            $range[] = $i;
        }
            
        return  [ 'sum'=>$sum,'range' =>$range];
    }
}
