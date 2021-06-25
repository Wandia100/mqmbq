<?php

namespace app\models;


use Yii;
use app\models\Stations;
use app\models\MpesaPayments;
use app\models\TransactionHistories;

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
            [['amount', 'invalid_codes', 'total_amount','day_total'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['hour_date'], 'string', 'max' => 15],
            [['unique_field'], 'string', 'max' => 20],
            [['station_id', 'hour'], 'string', 'max' => 255],
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
    public static function checkDuplicate($the_day,$hr)
    {
        return HourlyPerformanceReports::find()->where("hour_date='$the_day'")->andWhere("hour='$hr'")->count();
    }
    public static function stationHourRecord($the_day,$hr,$station_id)
    {
        return HourlyPerformanceReports::find()->where("hour_date='$the_day'")
        ->andWhere("hour='$hr'")->andWhere("station_id='$station_id'")->one();
    }
    /**
     * Method to generate hourly report
     */
    public function hourlyReport(){
        $today=(isset($_GET['from'])?$_GET['from']:date("Y-m-d"));
        $current_time = date("H");
        $transaction_history_result = array();
        $start=0;
        $end=0;
        if($current_time >= 0 && $current_time < 8){
            $start=0;
            $end=8;
        }
        else if($current_time >= 8 && $current_time < 16){
            $start=8;
            $end=16;
        }
        else if($current_time >= 16 && $current_time < 24){
            $start=16;
            $end=24;
        }
        $start=0;
        $end=24;
        $stations=Stations::getActiveStations();
        
        $response=array();
        #station names
        $station_names=array();
        array_push($station_names,"HOUR");
        for($i=0;$i<count($stations); $i++)
        {
            array_push($station_names,$stations[$i]->name);
        }
        array_push($station_names,"INVALIDCODES");
        array_push($station_names,"TOTAL");
        array_push($response,$station_names);
        for($i = $start; $i< $end; $i++)
        {
            $hour_record=array();
            $from_time=$today." ".Yii::$app->myhelper->formatHour($i);
            array_push($hour_record,Yii::$app->myhelper->formatHour($i));
            if(Yii::$app->myhelper->formatHour($i) < date('H'))
            {
                $invalid=0;
                $totalAmount=0;
                //set station amounts
                for($a=0;$a<count($stations); $a++)
                {
                    $row=$stations[$a];
                    $stationData=HourlyPerformanceReports::stationHourRecord($today,Yii::$app->myhelper->formatHour($i),$row->id);
                    if($stationData)
                    {
                        $invalid=$stationData->invalid_codes;
                        $totalAmount=$stationData->total_amount;
                        array_push($hour_record,$stationData->amount);
                    }
                    else
                    {
                        array_push($hour_record,0);
                    }
                    
                }
                array_push($hour_record,$invalid);
                array_push($hour_record,$totalAmount);
            }
            else
            {
                if($today==date("Y-m-d") && $i> date('H'))
                {
                    for($a=0;$a<count($stations);$a++)
                    {
                        array_push($hour_record,0);
                    }
                    array_push($hour_record,0);
                    array_push($hour_record,0);
                    
                }
                else
                {
                    $station_result = Stations::getStationResult($from_time);
                    for($a=0;$a <count($station_result);$a++)
                    {
                        array_push($hour_record,$station_result[$a]['amount']);
                    }
                    $mpesa_payments = MpesaPayments::getTotalMpesa($from_time);
                    $mpesa_payments=$mpesa_payments['total_mpesa'];
                    $transaction_histories = TransactionHistories::getTotalTransactions($from_time);
                    $transaction_histories = $transaction_histories['total_history'];
                    $invalid_codes = $mpesa_payments - $transaction_histories;
                    array_push($hour_record,$invalid_codes);
                    array_push($hour_record,$mpesa_payments);
                }

            }
            array_push($response,$hour_record);
            
        }
        $start_period=$today." ".$start.":00";
        $end_period=$today." ".($end-1).":59";
        //$range_result = Stations::getStationTotalResult($start_period,$end_period);
        $range_result = Stations::getStationResult($today);
        $arr=array();
        array_push($arr,"RANGE TOTAL");
        for($i=0;$i<count($range_result); $i++)
        {
            array_push($arr,$range_result[$i]['amount']);
        }
        $mpesaRange=MpesaPayments::getTotalMpesaInRange($start_period,$end_period);
        $invalidRange=TransactionHistories::getTotalTransactionsInRange($start_period,$end_period);
        $invalidRange=$mpesaRange['total_mpesa']-$invalidRange['total_history'];
        array_push($arr,$invalidRange);
        array_push($arr,$mpesaRange['total_mpesa']);
        array_push($response,$arr);
        //$day_result = Stations::getDayStationTotalResult($today);
        $day_result = Stations::getStationResult($today);
        $arr=array();
        array_push($arr,"DAY TOTAL");
        for($i=0;$i<count($day_result); $i++)
        {
            array_push($arr,$day_result[$i]['amount']);
        }
        $mpesa_payments = MpesaPayments::getTotalMpesa($today);
        $mpesa_payments=$mpesa_payments['total_mpesa'];
        $transaction_histories = TransactionHistories::getTotalTransactions($today);
        $transaction_histories = $transaction_histories['total_history'];
        $invalid_codes = $mpesa_payments - $transaction_histories;
        array_push($arr,$invalid_codes);
        array_push($arr,$mpesa_payments);
        array_push($response,$arr);
        
        return $response;
        
    }
}
