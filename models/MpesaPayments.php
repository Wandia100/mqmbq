<?php

namespace app\models;

use Yii;
use Webpatser\Uuid\Uuid;

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
class MpesaPayments extends \yii\db\ActiveRecord
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
        return Yii::$app->mpesa_db;
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
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryOne();
    }
    public static function getStationTotalMpesa($from_time,$station_name)
    {
        $sql="SELECT COALESCE(SUM(b.TransAmount),0) as amount FROM comp21_mpesa.mpesa_payments b WHERE b.deleted_at IS NULL AND b.created_at LIKE :from_time 
        AND  (SUBSTRING(b.BillRefNumber,1,3)=SUBSTRING(:station_name,1,3) || RIGHT(b.BillRefNumber,3)=RIGHT(:station_name,3) || b.BillRefNumber LIKE :sname)";
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->bindValue(':station_name',$station_name)
        ->bindValue(':sname',"%$station_name%")
        ->queryOne();
    }
    public static function getTotalRevenue()
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from mpesa_payments";
        return Yii::$app->mpesa_db->createCommand($sql)->queryOne();
    }
    public static function getTotalMpesaInRange($from_time,$to_time)
    {
        $sql="select COALESCE(sum(TransAmount),0) as total_mpesa from 
        mpesa_payments where created_at >= :from_time and
        created_at <= :to_time";
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->queryOne();
    }
    public static function revenueReport($start_date,$end_date)
    {
        $sql='SELECT DATE_FORMAT(a.created_at, "%Y-%m-%d") AS the_day FROM mpesa_payments a
        WHERE a.created_at BETWEEN :start_date AND :end_date group by the_day ORDER BY the_day DESC;';
        return Yii::$app->mpesa_db->createCommand($sql)
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
            $sum = MpesaPayments::getTotalMpesaInRange($midnight,$today)['total_mpesa'];
            break;
        case 'yesterday':
            $yestFloor = date( 'Y-m-d 00:00:00',strtotime('-1 day', time()));
            $yestCeil = date( 'Y-m-d 23:59:59',strtotime('-1 day', time()));
            $sum = MpesaPayments::getTotalMpesaInRange($yestFloor, $yestCeil)['total_mpesa'];
            break;
        case 'last_7_days':
            $_7daysFloor = date( 'Y-m-d 00:00:00',strtotime('-7 day', time()));
            $sum = MpesaPayments::getTotalMpesaInRange($_7daysFloor, $today)['total_mpesa'];
            break;
        case 'currentmonth':
            $cFloor = date( 'Y-m-1 00:00:00');
            $sum = MpesaPayments::getTotalMpesaInRange($cFloor, $today)['total_mpesa'];
            break;
        case 'lastweek':
            $floorDate = date("Y-m-d 00:00:00", strtotime(date("w") ? "2 sundays ago" : "last sunday"));
            $ceilDate = date("Y-m-d 23:59:59", strtotime("last saturday"));
            $sum = MpesaPayments::getTotalMpesaInRange($floorDate, $ceilDate)['total_mpesa'];
            break;
        case 'lastmonth':
            $lFloor = date( 'Y-m-1 00:00:00',strtotime('-1 month', time()));
            $lCeil = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
            $sum = MpesaPayments::getTotalMpesaInRange($lFloor, $lCeil)['total_mpesa'];
            break;
        default :   
            $sum = MpesaPayments::getTotalRevenue()['total_mpesa'];
        endswitch;
        return number_format($sum);    
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
                $mod = MpesaPayments::find()->where("TransID = '$col1'")->one();
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
                    $mod= new MpesaPayments();
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
        return Yii::$app->mpesa_db->createCommand($sql)
        ->queryAll();
    }
    public static function removeDups($unique_field,$limits)
    {
        $sql='DELETE FROM mpesa_payments WHERE TransID=:TransID LIMIT :limits';
        Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':TransID',$unique_field)
        ->bindValue(':limits',$limits)
        ->execute();
    }
}
