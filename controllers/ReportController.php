<?php
namespace app\controllers;
use Yii;
use app\models\MpesaPayments;
use app\models\TransactionHistories;
use app\models\Stations;
use yii\web\Controller;
use yii\filters\VerbFilter;
class ReportController extends Controller{
        /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->isGuest){
                                return TRUE;
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionHourlyperformance()
    {
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
            $from_time=$today." ".$this->formatHour($i);
            array_push($hour_record,$this->formatHour($i));
            $station_result = Stations::getStationResult($from_time);
            for($a=0;$a <count($station_result);$a++)
            {
                array_push($hour_record,$station_result[$a]['amount']);
            }
            $mpesa_payments = MpesaPayments::getTotalMpesa($from_time);
            $mpesa_payments=$mpesa_payments['total_mpesa'];
            $transaction_histories = TransactionHistories::getTotalTransactions($today);
            $transaction_histories = $transaction_histories['total_history'];
            $invalid_codes = $mpesa_payments - $transaction_histories;
            array_push($hour_record,$invalid_codes);
            array_push($hour_record,$mpesa_payments);
            array_push($response,$hour_record);
        }
        $start_period=$today." ".$start.":00";
        $end_period=$today." ".($end-1).":59";
        $range_result = Stations::getStationTotalResult($start_period,$end_period);
        $arr=array();
        array_push($arr,"RANGE TOTAL");
        for($i=0;$i<count($range_result); $i++)
        {
            array_push($arr,$range_result[$i]['amount']);
        }
        array_push($response,$arr);
        $day_result = Stations::getDayStationTotalResult($today);
        $arr=array();
        array_push($arr,"DAY TOTAL");
        for($i=0;$i<count($day_result); $i++)
        {
            array_push($arr,$day_result[$i]['amount']);
        }
        array_push($response,$arr);
        return $this->render('hourly_performance', [
            'response' => $response
            ]);
    }
    public function actionCommissionsummary()
    {
        
    }
    public function actionDailyawarding()
    {

    }
    public function actionRevenue()
    {

    }
    public function actionCommission()
    {

    }
    public function actionDashboard()
    {}
    private function formatHour($hr)
    {
        if($hr < 10)
        {
            return '0'.$hr;
        }
        else
        {
            return $hr;
        }
    }
    public function actionDemo()
    {
        $stations=Stations::getActiveStations();
        $today=date("Y-m-d");
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
        for($i = $start; $i< $end; $i++){
            $i=$this->formatHour($i);
            $total_amount = 0;
            $total_invalid_codes = 0;
            $from_time=$today." ".$i;
            $mpesa_payments = MpesaPayments::getTotalMpesa($from_time);
            $mpesa_payments=$mpesa_payments['total_mpesa'];
            $transaction_histories = TransactionHistories::getTotalTransactions($from_time);
            $transaction_histories=$transaction_histories['total_history'];
            $invalid_codes = $mpesa_payments - $transaction_histories;
            $total_invalid_codes = $total_invalid_codes + $invalid_codes;
            $total_amount = $total_amount + $mpesa_payments;
            $station_result = Stations::getStationResult($from_time);
            array_push($transaction_history_result,
                array(
                    'hour' => $i,
                    'hour_results' => $station_result,
                    'total_amount' => $total_amount,
                    'total_invalid_codes' => $total_invalid_codes,
                ));
        }
        $overall_station_total_result = array();
        $start_period=$today." ".$start.":00";
        $end_period=$today." ".($end-1).":59";
        $station_total_result = Stations::getStationTotalResult($start_period,$end_period);
        $overall_station_total_result = Stations::getDayStationTotalResult($today);
        $mpesa_payments = MpesaPayments::getTotalMpesa($today);
        $mpesa_payments = $mpesa_payments['total_mpesa'];
        $transaction_histories = TransactionHistories::getTotalTransactions($today);
        $transaction_histories = $transaction_histories['total_history'];
        $invalid_codes = $mpesa_payments - $transaction_histories;
        $json_array = array(
            'transaction_histories' => $transaction_history_result,
            'overall_station_totals' => $overall_station_total_result,
            'overall_invalid_codes' => $invalid_codes,
            'overall_total_amount' => $mpesa_payments,
            'station_totals' => $station_total_result,
        );

        $hourly = $json_array;
        return $hourly;
    }
}
?>