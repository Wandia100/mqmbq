<?php
namespace app\controllers;
use Yii;
use app\models\MpesaPayments;
use app\models\TransactionHistories;
use app\models\Stations;
use app\models\Commissions;
use app\models\HourlyPerformanceReports;
use app\models\WinningHistories;
use app\models\StationShows;
use app\models\ShowSummary;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use app\components\Myhelper;

class ReportController extends Controller{
        /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['hourlyperformance', 'presentercommission','dailyawarding','revenue','commissionsummary','showsummary'],
                'rules' => [
                    [
                        'actions' => ['hourlyperformance'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(34) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['presentercommission'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(35) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['dailyawarding'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(36) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['revenue'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(37) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['commissionsummary'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(38) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['showsummary'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(40) );
                                return in_array( Yii::$app->user->identity->email, $users );
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
            if($this->formatHour($i) < date('H'))
            {
                $invalid=0;
                $totalAmount=0;
                //set station amounts
                for($a=0;$a<count($stations); $a++)
                {
                    $row=$stations[$a];
                    $stationData=HourlyPerformanceReports::stationHourRecord($today,$this->formatHour($i),$row->id);
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
        $act = new \app\models\ActivityLog();
        $act -> desc = "hourly_performance report";
        $act ->setLog();
        return $this->render('hourly_performance', [
            'response' => $response
            ]);
    }
    public function actionShowsummary()
    {
        $start_date= date('Y-m-d',strtotime('yesterday'));
        $end_date = $start_date;
        if ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'daily' ) {
            $start_date= date('Y-m-d',strtotime('yesterday'));
            $end_date = $start_date;
            $response=ShowSummary::getShowSummary($start_date,$end_date);
        } elseif ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'monthly' ) {
            $start_date= date('Y-m-01');
            $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
            $end_date = date("Y-m-$d");
            $response=ShowSummary::getShowSummary($start_date,$end_date);
        } elseif ( isset( $_GET['criterion'] ) && $_GET['criterion'] == 'range' ) {
                if ( isset( $_GET['from'] ) && isset( $_GET['to'] ) ) {
                        $end_date       = $_GET['to'];
                        $start_date     = $_GET['from'];
                        $date1    = strtotime( $end_date);
                        $date2    = strtotime( $start_date);
                        if ( $date1 < $date2 ) {
                                Yii::$app->session->setFlash('error', 'Error: start date should be before the end date' );
                        }
                        $response=ShowSummary::getShowSummary($start_date,$end_date);
                } else {
                    $start_date= date('Y-m-01');
                    $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
                    $end_date = date("Y-m-$d");
                    $response=ShowSummary::getShowSummary($start_date,$end_date);
                }
        } else {
            $response=ShowSummary::getShowSummary($start_date,$end_date);
        }
        return $this->render('show_summary', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'response' => $response
            ]);
    }
    public function actionLogshowsummary()
    {
        $start_date= date('Y-m-d',strtotime('yesterday'));
        $end_date = date("$start_date 23:59:59");
        if(ShowSummary::checkDuplicate($start_date)== 0)
        {
            
            $data=StationShows::getStationShowSummary($start_date,$end_date);
            for($i=0;$i<count($data); $i++)
            {
                $row=$data[$i];
                $model=new ShowSummary();
                $model->station_show_id=$row['id'];
                $model->total_revenue=$row['total_revenue'];
                $model->total_commission=$row['total_commission'];
                $model->total_payouts=$row['total_payout'];
                $model->report_date= $start_date;
                $model->created_at=date("Y-m-d H:i:s");
                $model->station_show_name=$row['station_show_name'];
                $model->station_name=$row['station_name'];
                $model->save();
            }
        }
    }
    public function actionLasthour()
    {
        Myhelper::checkRemoteAddress();
        $the_day=date("Y-m-d");
        $hr=$this->formatHour(date('H')-1);
        $from_time=$the_day." ".$hr;
        $count=HourlyPerformanceReports::checkDuplicate($the_day,$hr);
        if($count==0)
        {
            $stations=Stations::getActiveStations();
            for($i=0;$i<count($stations); $i++)
            {
                try
                {
                $station=$stations[$i];
                $model=new HourlyPerformanceReports();
                $model->hour=$hr;
                $model->hour_date=$the_day;
                $model->unique_field=date('Ymd').$hr.$station->id;
                $model->station_id=$station->id;
                $model->amount=MpesaPayments::getStationTotalMpesa($from_time,$station->station_code)['amount'];
                $mpesa_payments = MpesaPayments::getTotalMpesa($from_time)['total_mpesa'];
                $transaction_histories = TransactionHistories::getTotalTransactions($from_time)['total_history'];
                $model->invalid_codes=$mpesa_payments - $transaction_histories;
                $model->total_amount=$mpesa_payments;
                $model->day_total=MpesaPayments::getStationTotalMpesa($the_day,$station->station_code)['amount'];
                $model->created_at=date("Y-m-d H:i:s");
                $model->save(false);
                }
                catch (IntegrityException $e) {
                    //allow execution
                }
            }
            
        }
    }
    public function actionLogdata($the_day)
    {
        for($i=0;$i<24;$i++)
        {
            if($the_day==date("Y-m-d") && $this->formatHour($i) >=date('H') )
            {
                break;
            }
            $hr=$this->formatHour($i);
            $from_time=$the_day." ".$hr;
            $count=HourlyPerformanceReports::checkDuplicate($the_day,$hr);
            if($count==0)
            {
                $stations=Stations::getActiveStations();
                for($j=0;$j<count($stations); $j++)
                {
                    try
                    {
                    $station=$stations[$j];
                    $model=new HourlyPerformanceReports();
                    $model->hour=$hr;
                    $model->hour_date=$the_day;
                    $model->unique_field=$the_day.$hr.$station->id;
                    $model->station_id=$station->id;
                    $model->amount=MpesaPayments::getStationTotalMpesa($from_time,$station->station_code)['amount'];
                    $mpesa_payments = MpesaPayments::getTotalMpesa($from_time)['total_mpesa'];
                    $transaction_histories = TransactionHistories::getTotalTransactions($from_time)['total_history'];
                    $model->invalid_codes=$mpesa_payments - $transaction_histories;
                    $model->total_amount=$mpesa_payments;
                    $model->day_total=MpesaPayments::getStationTotalMpesa($the_day,$station->station_code)['amount'];
                    $model->created_at=date("Y-m-d H:i:s");
                    $model->save(false);
                    }
                    catch (IntegrityException $e) {
                        //allow execution
                    }
                }
                
            }
        }
    }
    public function actionCommissionsummary()
    {
        
        if(isset($_GET['criterion']) && $_GET['criterion']=="monthly")
        {
            $start_date=date("Y-m-01");    
            $end_date=date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));    
        }
        else if(isset($_GET['criterion']) && $_GET['criterion']=="daily")
        {
            $start_date=date("Y-m-01");    
            $end_date=date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));    
        }
        else{
            $start_date=(isset($_GET['from'])?$_GET['from']:date("Y-m-d"));
            //$end_date=(isset($_GET['to'])?$_GET['to']:date("Y-m-d",strtotime("+1 day",time())));
            $end_date=date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));
        }
        $data=Commissions::commissionSummary($start_date,$end_date);
        $act = new \app\models\ActivityLog();
        $act -> desc = "commission_summary report";
        $act ->setLog();
        return $this->render('commission_summary', [
            'data' => $data
        ]);
    }
    public function actionDailyawarding()
    {
        if(isset($_GET['criterion']) && $_GET['criterion']=="monthly")
        {
            $start_date=date("Y-m-01");    
            $end_date=date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));    
        }
        else{
            $start_date=(isset($_GET['from'])?$_GET['from']:date("Y-m-d"));
            $end_date=(isset($_GET['to'])?date('Y-m-d', strtotime($_GET['to']. ' + 1 day')):date("Y-m-d",strtotime("+1 day",time())));
        }
        $data=WinningHistories::dailyAwarding($start_date,$end_date);
        $act = new \app\models\ActivityLog();
        $act -> desc = "daily_awarding report";
        $act ->setLog();
        return $this->render('daily_awarding', [
            'data' => $data
        ]);
    }
    public function actionRevenue()
    {
        if(isset($_GET['criterion']) && $_GET['criterion']=="monthly")
        {
            $start_date=date("Y-m-01");    
            $end_date=date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));    
        }
        else{
            $start_date=(isset($_GET['from'])?$_GET['from']:date("Y-m-d"));
            $end_date=(isset($_GET['to'])?date('Y-m-d', strtotime($_GET['to']. ' + 1 day')):date("Y-m-d",strtotime("+1 day",time())));
        }
        $data=MpesaPayments::revenueReport($start_date,$end_date);
        $resp=[];
        for($i=0;$i<count($data);$i++)
        {
            $row=$data[$i];
            $row['payout']=WinningHistories::getPayout($row['the_day'])['total'];
            $row['total_revenue']=MpesaPayments::getTotalMpesa($row['the_day'])['total_mpesa'];
            array_push($resp,$row);
        }
        $act = new \app\models\ActivityLog();
        $act -> desc = "revenue report";
        $act ->setLog();
        return $this->render('revenue', [
            'data' => $resp
        ]);
    }
    public function actionPresentercommission()
    {
        $data=Commissions::presenterCommission(Yii::$app->user->identity->id);
        
        return $this->render('presenter_commission', [
            'data' => $data
        ]);
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
