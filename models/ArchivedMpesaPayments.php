<?php

namespace app\models;

use app\components\Myhelper;
use Yii;
use Webpatser\Uuid\Uuid;
use app\models\RevenueReport;
use yii\db\IntegrityException;

/**
 * This is the model class for table "mpesa_payments".
 *
 * @property string $id
 * @property string|null $TransID
 * @property string|null $FirstName
 * @property string|null $MiddleName
 * @property string|null $LastName
 * @property string|null $MSISDN
 * @property string|null $InvoiceNumber
 * @property string|null $BusinessShortCode
 * @property string|null $ThirdPartyTransID
 * @property string|null $TransactionType
 * @property string|null $OrgAccountBalance
 * @property string|null $BillRefNumber
 * @property string|null $TransAmount
 * @property int $is_archived
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class ArchivedMpesaPayments extends \yii\db\ActiveRecord
{
    
    public  $excelfile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesa_payments';
    }
    public static function getDb() {
        return Yii::$app->analytics_db;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['is_archived'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['operator'], 'string', 'max' => 20],
            [['station_id'], 'string', 'max' => 50],
            [['excelfile'], 'required'],
            [['excelfile'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'csv'],
            [['TransID', 'deleted_at'], 'string', 'max' => 100],
            [['FirstName', 'MiddleName', 'LastName', 'MSISDN', 'InvoiceNumber', 'BusinessShortCode', 'ThirdPartyTransID', 'TransactionType', 'OrgAccountBalance', 'BillRefNumber', 'TransAmount'], 'string', 'max' => 255],
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
            'TransID' => 'Trans ID',
            'FirstName' => 'First Name',
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'MSISDN' => 'Msisdn',
            'InvoiceNumber' => 'Invoice Number',
            'BusinessShortCode' => 'Business Short Code',
            'ThirdPartyTransID' => 'Third Party Trans ID',
            'TransactionType' => 'Transaction Type',
            'OrgAccountBalance' => 'Org Account Balance',
            'BillRefNumber' => 'Bill Ref Number',
            'TransAmount' => 'Trans Amount',
            'is_archived' => 'Is Archived',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getTotalMpesa($from_time)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments where deleted_at IS NULL AND created_at 
        LIKE :from_time";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryOne();
    }
    public static function getTotalMpesaPerStation($from_time,$station_id)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments where deleted_at IS NULL AND created_at 
        LIKE :from_time AND station_id=:station_id";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->bindValue(':station_id',$station_id)
        ->queryOne();
    }
    public static function getStationTotalMpesa($from_time,$station_code)
    {
        $sql="SELECT COALESCE(SUM(b.TransAmount),0) as amount FROM mpesa_payments b WHERE b.deleted_at IS NULL AND b.created_at LIKE :from_time 
        AND  (SUBSTRING(b.BillRefNumber,1,3)=SUBSTRING(:station_code,1,3) || RIGHT(b.BillRefNumber,3)=RIGHT(:station_code,3) || b.BillRefNumber LIKE :sname)";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->bindValue(':station_code',$station_code)
        ->bindValue(':sname',"%$station_code%")
        ->queryOne();
    }
    public static function getStationTotalMpesaNet($from_time)
    {
        $sql="SELECT COALESCE(SUM(b.TransAmount),0) as amount FROM mpesa_payments b WHERE b.deleted_at IS NULL AND b.created_at LIKE :from_time 
        AND  LENGTH(b.BillRefNumber)=1";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryOne();
    }
    public static function getTotalRevenue()
    {
        if(\Yii::$app->myhelper->isStationManager())
        {
            $stations = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getStations()));
            $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments 
            AND station_id IN ($stations)";        
        }
        else
        {
            $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments";
        }
        
        return Yii::$app->analytics_db->createCommand($sql)->queryOne();
    }
    public static function getTotalRevenuePerStation($station_id)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments where station_id=:station_id";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':station_id',$station_id)
        ->queryOne();
    }
    public static function getTotalMpesaInRange($from_time,$to_time)
    {
        if(\Yii::$app->myhelper->isStationManager())
        {
            $stations = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getStations()));
            $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from 
                    mpesa_payments where created_at >= :from_time and
                    created_at <= :to_time AND station_id IN ($stations)";        
        }
        else
        {
            $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from 
                mpesa_payments where created_at >= :from_time and
                created_at <= :to_time";
        }
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->queryOne();
    }
    public static function getTotalMpesaInRangePerStation($from_time,$to_time,$station_id)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from 
        mpesa_payments where created_at >= :from_time and
        created_at <= :to_time and station_id=:station_id";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->bindValue(':station_id',$station_id)
        ->queryOne();
    }
    public static function revenueReport($start_date,$end_date)
    {
        $sql='SELECT DATE_FORMAT(a.created_at, "%Y-%m-%d") AS the_day FROM mpesa_payments a
        WHERE a.created_at BETWEEN :start_date AND :end_date group by the_day ORDER BY the_day DESC;';
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    /**
     * Method to get mpesa counts
     * @param type $type
     */
    public static function getMpesaCounts($type){
        $today = date('Y-m-d H:i:s');
        $sum = 0;
        switch ($type):
        case 'today':
            $midnight = date('Y-m-d 00:00:00');
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($midnight,$today)['total_mpesa'];
            break;
        case 'yesterday':
            $yestFloor = date( 'Y-m-d 00:00:00',strtotime('-1 day', time()));
            $yestCeil = date( 'Y-m-d 23:59:59',strtotime('-1 day', time()));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($yestFloor, $yestCeil)['total_mpesa'];
            break;
        case 'last_7_days':
           // $_7daysFloor = date( 'Y-m-d 00:00:00',strtotime('-7 day', time())); //Change to check from monday to today
            $_lastMonday = date('Y-m-d 00:00:00',strtotime('Monday this week'));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($_lastMonday, $today)['total_mpesa'];
            break;
        case 'currentmonth':
            $cFloor = date( 'Y-m-1 00:00:00');
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($cFloor, $today)['total_mpesa'];
            break;
        case 'lastweek':
            $floorDate = date("Y-m-d 00:00:00", strtotime(date("w") ? "2 sundays ago" : "last sunday"));
            $ceilDate = date("Y-m-d 23:59:59", strtotime("last saturday"));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($floorDate, $ceilDate)['total_mpesa'];
            break;
        case 'lastmonth':
            $lFloor = date( 'Y-m-1 00:00:00',strtotime('-1 month', time()));
            $lCeil = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRange($lFloor, $lCeil)['total_mpesa'];
            break;
        default :   
            $sum = ArchivedMpesaPayments::getTotalRevenue()['total_mpesa'];
        endswitch;
        return $sum;    
    }
    public static function getMpesaCountsPerStation($type,$station_id){
        $today = date('Y-m-d H:i:s');
        $sum = 0;
        switch ($type):
        case 'today':
            $midnight = date('Y-m-d 00:00:00');
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($midnight,$today,$station_id)['total_mpesa'];
            break;
        case 'yesterday':
            $yestFloor = date( 'Y-m-d 00:00:00',strtotime('-1 day', time()));
            $yestCeil = date( 'Y-m-d 23:59:59',strtotime('-1 day', time()));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($yestFloor, $yestCeil,$station_id)['total_mpesa'];
            break;
        case 'last_7_days':
           // $_7daysFloor = date( 'Y-m-d 00:00:00',strtotime('-7 day', time())); //Change to check from monday to today
            $_lastMonday = date('Y-m-d 00:00:00',strtotime('Monday this week'));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($_lastMonday, $today,$station_id)['total_mpesa'];
            break;
        case 'currentmonth':
            $cFloor = date( 'Y-m-1 00:00:00');
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($cFloor, $today,$station_id)['total_mpesa'];
            break;
        case 'lastweek':
            $floorDate = date("Y-m-d 00:00:00", strtotime(date("w") ? "2 sundays ago" : "last sunday"));
            $ceilDate = date("Y-m-d 23:59:59", strtotime("last saturday"));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($floorDate, $ceilDate,$station_id)['total_mpesa'];
            break;
        case 'lastmonth':
            $lFloor = date( 'Y-m-1 00:00:00',strtotime('-1 month', time()));
            $lCeil = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
            $sum = ArchivedMpesaPayments::getTotalMpesaInRangePerStation($lFloor, $lCeil,$station_id)['total_mpesa'];
            break;
        default :   
            $sum = ArchivedMpesaPayments::getTotalRevenuePerStation($station_id)['total_mpesa'];
        endswitch;
        return $sum;    
    }
    
    /**
     * Method to upload excel
     *
     * @return boolean
     */
    public function upload(){
        #echo 'am here'; exit;
        $basePath = 'uploads/' . $this->excelfile->baseName . '.' . $this->excelfile->extension;//readable
        $this->excelfile->saveAs( $basePath );
        
       // ini_set('auto_detect_line_endings', TRUE);
        $handle = fopen($basePath, "r");
        $row =0;
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
        {
            if($row >= 6){
                $col1 = trim($fileop[0]);
                $namespn = explode('-', trim($fileop[10]));
                $names = isset($namespn[1])?explode(' ', trim($namespn[1])):[];
                $mod = ArchivedMpesaPayments::find()->where("TransID = '$col1'")->one();
                if(!$mod){
                    if (isset($fileop[0]) && isset($fileop[2]) && isset($fileop[5])  && isset($fileop[10]) )
                    {
                    $msisdn=explode("-",$fileop[10]);
                    $msisdn=trim($msisdn[0]);
                    if($msisdn[0]=="0")
                    {
                        $msisdn='254'.substr($msisdn,1);
                    }
                    else
                    {
                        $msisdn=trim($msisdn);
                    }
                    $mod= new ArchivedMpesaPayments();
                    $mod->id=Uuid::generate()->string;
                    $mod ->TransID = $col1;
                    $mod -> TransAmount = $fileop[5];
                    $mod -> FirstName = isset($names[0])?$names[0]:NULL; 
                    $mod -> MiddleName = isset($names[1])?$names[1]:NULL; 
                    $mod -> LastName = isset($names[2])?$names[2]:NULL; 
                    $mod -> MSISDN = $msisdn; 
                    $mod -> BillRefNumber = $fileop[12]; 
                    $mod -> OrgAccountBalance =$fileop[7]; 
                    $mod -> TransactionType =$fileop[9]; 
                    $mod -> created_at = date("Y-m-d H:i:s",strtotime($fileop[2]));
                    $mod -> updated_at = date('Y-m-d H:i:s');
                    $mod ->save(FALSE);

                }
                }
            }
            $row++;
        }
    }
    public static function getDuplicates()
    {
        $sql='SELECT COUNT(TransID) AS total,TransID FROM mpesa_payments  GROUP BY TransID HAVING(total > 1)';
        return Yii::$app->analytics_db->createCommand($sql)
        ->queryAll();
    }
    public static function removeDups($unique_field,$limits)
    {
        $sql='DELETE FROM mpesa_payments WHERE TransID=:TransID LIMIT :limits';
        Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':TransID',$unique_field)
        ->bindValue(':limits',$limits)
        ->execute();
    }
    public static function logRevenue($revenue_date)
    {
            $stations=Stations::find()->where("deleted_at is null")->orderBy("name asc")->all();
            for($i=0; $i<count($stations); $i++)
            {
                $row=$stations[$i];
                try
                {
                    $unique_field=$row->id.$revenue_date;
                    $report=RevenueReport::checkDuplicate($unique_field);
                    if($report==NULL)
                    {
                        $model=new RevenueReport();
                        $model->revenue_date=$revenue_date;
                        $model->station_id=$row->id;
                        $model->station_name=$row->name;
                        $model->total_awarded=WinningHistories::getPayoutPerStation($revenue_date,$row->id)['total'];
                        $model->total_revenue=ArchivedMpesaPayments::getTotalMpesaPerStation($revenue_date,$row->id)['total_mpesa'];
                        $model->net_revenue=round($model->total_revenue-$model->total_awarded);
                        $model->unique_field=$unique_field;
                        $model->save(false);
                    }
                    else
                    {
                        $report->total_awarded=WinningHistories::getPayoutPerStation($revenue_date,$row->id)['total'];
                        $report->total_revenue=ArchivedMpesaPayments::getTotalMpesaPerStation($revenue_date,$row->id)['total_mpesa'];
                        $report->net_revenue=round($report->total_revenue-$report->total_awarded);
                        $report->save(false);
                    }
                    
                }
                catch(IntegrityException $e)
                {
                    //allow execution
                }
            }
           
    }
    public static function getPlayerTrend($created_at)
    {
        $sql="SELECT COUNT(MSISDN) AS frequency,MSISDN AS msisdn,station_id,BillRefNumber AS station FROM mpesa_payments WHERE created_at LIKE :created_at
        GROUP BY MSISDN,BillRefNumber,station_id";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':created_at',"$created_at%")
        ->queryAll();
    }
    public static function countAssignedCode($created_at)
    {
        $sql="select count(station_id) as total from mpesa_payments where created_at like :created_at and station_id is not null";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':created_at',"$created_at%")
        ->queryOne();
    }
    public static function countUnAssignedCode($created_at)
    {
        $sql="select count(*) as total from mpesa_payments where created_at like :created_at and station_id is null";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':created_at',"$created_at%")
        ->queryOne();
    }
    public static function getAssignedPerStation($created_at)
    {
        $sql="select count(station_id) as total,station_id from mpesa_payments where created_at like :created_at and station_id is not null group by station_id order by total desc";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':created_at',"$created_at%")
        ->queryAll();
    }
    public static function calculateStationPercentage($created_at)
    {
        $total=ArchivedMpesaPayments::countAssignedCode($created_at)['total'];
        $unassigned=ArchivedMpesaPayments::countUnAssignedCode($created_at)['total'];
        $data=ArchivedMpesaPayments::getAssignedPerStation($created_at);
        for($i=0; $i<count($data); $i++)
        {
            $row=$data[$i];
            $percent=round(($row['total']/$total),2);
            $stop=ceil($percent*$unassigned);
            //update this percentage
            if($stop > 0)
            {
                $station_code=Stations::findOne($row['station_id'])->station_code;
                ArchivedMpesaPayments::assignCode($row['station_id'],$created_at,$stop,$station_code);
            }
        }
    }
    public static function assignCode($station_id,$created_at,$stop,$station_code)
    {
        $sql="update mpesa_payments set station_id=:station_id,BillRefNumber=:station_code,updated_at=now() where created_at like :created_at and station_id is null limit $stop";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':station_id',$station_id)
        ->bindValue(':station_code',$station_code)
        ->bindValue(':created_at',"$created_at%")
        ->execute();
    }
    public static function setStation()
    {
        $data=ArchivedMpesaPayments::find()->where("station_id IS NULL")->all();
        foreach($data as $row)
        {
            $model=TransactionHistories::findOne(["mpesa_payment_id"=>$row->id]);
            if($model!=NULL)
            {
                $row->station_id=$model->station_id;
                $row->updated_at=date("Y-m-d H:i:s");
                $row->operator=Myhelper::getOperator($row->MSISDN);
                $row->save(false);
            }
        }

    }
}
