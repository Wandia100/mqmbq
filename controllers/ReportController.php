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
                    'station_totals' => $station_result,
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
        return $this->render('hourly_performance', [
            'hourly' => $hourly,
            'stations' => $stations
            ]);
    }
    private function formatHour($hr)
    {
        if($hr < 10)
        {
            return '0'.$hr;
        }
    }

}
?>