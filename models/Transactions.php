<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property string $id
 * @property string $user_id
 * @property string $category_id
 * @property string $category_item_id
 * @property string $name
 * @property string|null $description
 * @property string $item_code
 * @property string $mode_payment
 * @property float $amount
 * @property int $quantity
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Transactions extends \yii\db\ActiveRecord
{
    public $quantityToReturn;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'category_item_id', 'name', 'item_code', 'mode_payment', 'amount', 'quantity'], 'required'],
            [['description', 'mode_payment'], 'string'],
            [['amount'], 'number'],
            [['quantity','quantityToReturn'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['user_id', 'category_id', 'category_item_id', 'name', 'item_code'], 'string', 'max' => 255],
            [['item_code'], 'unique'],
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
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'category_item_id' => 'Category Item ID',
            'name' => 'Name',
            'description' => 'Description',
            'item_code' => 'Item Code',
            'mode_payment' => 'Mode Payment',
            'amount' => 'Amount',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
    public function getCategoryItem()
    {
        return $this->hasOne(CategoryItems::className(), ['id' => 'category_item_id']);
    }
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public static function getPayout($the_day)
    {
        if(\Yii::$app->myhelper->isStationManager())
        {
            $stations = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getStations()));
            $sql="SELECT COALESCE(SUM(amount),0) AS total FROM transactions WHERE 
            created_at LIKE :the_day AND category_id IN ($stations)";        
        }
        else
        {
            $sql="SELECT COALESCE(SUM(amount),0) AS total FROM transactions WHERE 
         created_at LIKE :the_day";
        }
        
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':the_day',"%$the_day%")
        ->queryOne();
    }
    public static function getTotalMpesaInRange($from_time,$to_time)
    {
        if(\Yii::$app->myhelper->isStationManager())
        {
            $categories = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getCategories()));
            $sql="select COALESCE(sum(amount),0) as total_mpesa from 
                    transactions where created_at >= :from_time and
                    created_at <= :to_time AND category_id IN ($categories)";        
        }
        else
        {
            $sql="select COALESCE(sum(amount),0) as total_mpesa from 
                transactions where created_at >= :from_time and
                created_at <= :to_time";
        }
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->queryOne();
    }
    public static function getTotalRevenue()
    {
        if(\Yii::$app->myhelper->isStationManager())
        {
            $categories = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getStations()));
            $sql="select COALESCE(sum(amount),0) as total_mpesa from transactions 
            AND category_id IN ($categories)";        
        }
        else
        {
            $sql="select COALESCE(sum(amount),0) as total_mpesa from transactions";
        }
        
        return Yii::$app->db->createCommand($sql)->queryOne();
    }
    public static function getMpesaCounts($type){
        $today = date('Y-m-d H:i:s');
        $sum = 0;
        switch ($type):
        case 'today':
            $midnight = date('Y-m-d 00:00:00');
            $sum = Transactions::getTotalMpesaInRange($midnight,$today)['total_mpesa'];
            break;
        case 'yesterday':
            $yestFloor = date( 'Y-m-d 00:00:00',strtotime('-1 day', time()));
            $yestCeil = date( 'Y-m-d 23:59:59',strtotime('-1 day', time()));
            $sum = Transactions::getTotalMpesaInRange($yestFloor, $yestCeil)['total_mpesa'];
            break;
        case 'last_7_days':
           // $_7daysFloor = date( 'Y-m-d 00:00:00',strtotime('-7 day', time())); //Change to check from monday to today
            $_lastMonday = date('Y-m-d 00:00:00',strtotime('Monday this week'));
            $sum = Transactions::getTotalMpesaInRange($_lastMonday, $today)['total_mpesa'];
            break;
        case 'currentmonth':
            $cFloor = date( 'Y-m-1 00:00:00');
            $sum = Transactions::getTotalMpesaInRange($cFloor, $today)['total_mpesa'];
            break;
        case 'lastweek':
            $floorDate = date("Y-m-d 00:00:00", strtotime(date("w") ? "2 sundays ago" : "last sunday"));
            $ceilDate = date("Y-m-d 23:59:59", strtotime("last saturday"));
            $sum = Transactions::getTotalMpesaInRange($floorDate, $ceilDate)['total_mpesa'];
            break;
        case 'lastmonth':
            $lFloor = date( 'Y-m-1 00:00:00',strtotime('-1 month', time()));
            $lCeil = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
            $sum = Transactions::getTotalMpesaInRange($lFloor, $lCeil)['total_mpesa'];
            break;
        default :   
            $sum = Transactions::getTotalRevenue()['total_mpesa'];
        endswitch;
        return $sum;    
    }
    public static function getCategoryTotalMpesa($from_time,$category_id)
    {
        $sql="SELECT COALESCE(SUM(b.amount),0) as amount FROM transactions b 
        WHERE b.deleted_at IS NULL AND b.created_at LIKE :from_time AND b.category_id=:category_id";
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->bindValue(':category$category_id',"$category_id")
        ->queryOne();
    }
    public static function getTotalMpesaInRangePerCategory($from_time,$to_time,$category_id)
    {
        $sql="select COALESCE(sum(amount),0) as total_mpesa from 
        transactions where created_at >= :from_time and
        created_at <= :to_time and category_id=:category_id";
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':from_time',$from_time)
        ->bindValue(':to_time',$to_time)
        ->bindValue(':category_id',$category_id)
        ->queryOne();
    }
    public static function getTotalRevenuePerCategory($category_id)
    {
        $sql="select COALESCE(sum(amount),0) as total_mpesa from transactions where category_id=:category_id";
        return Yii::$app->mpesa_db->createCommand($sql)
        ->bindValue(':category_id',$category_id)
        ->queryOne();
    }
    public static function getPayoutPerCategory($the_day,$category_id)
    {
        $sql="SELECT COALESCE(SUM(amount),0) AS total FROM transactions WHERE 
         created_at LIKE :the_day AND category_id=:category_id";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':the_day',"%$the_day%")
        ->bindValue(':category_id',$category_id)
        ->queryOne();
    }
    public static function getMpesaCountsPerCategory($type,$category_id){
        $today = date('Y-m-d H:i:s');
        $sum = 0;
        switch ($type):
        case 'today':
            $midnight = date('Y-m-d 00:00:00');
            $sum = Transactions::getTotalMpesaInRangePerCategory($midnight,$today,$category_id)['total_mpesa'];
            break;
        case 'yesterday':
            $yestFloor = date( 'Y-m-d 00:00:00',strtotime('-1 day', time()));
            $yestCeil = date( 'Y-m-d 23:59:59',strtotime('-1 day', time()));
            $sum = Transactions::getTotalMpesaInRangePerCategory($yestFloor, $yestCeil,$category_id)['total_mpesa'];
            break;
        case 'last_7_days':
           // $_7daysFloor = date( 'Y-m-d 00:00:00',strtotime('-7 day', time())); //Change to check from monday to today
            $_lastMonday = date('Y-m-d 00:00:00',strtotime('Monday this week'));
            $sum = Transactions::getTotalMpesaInRangePerCategory($_lastMonday, $today,$category_id)['total_mpesa'];
            break;
        case 'currentmonth':
            $cFloor = date( 'Y-m-1 00:00:00');
            $sum = Transactions::getTotalMpesaInRangePerCategory($cFloor, $today,$category_id)['total_mpesa'];
            break;
        case 'lastweek':
            $floorDate = date("Y-m-d 00:00:00", strtotime("Monday last week"));
            $ceilDate = date("Y-m-d 23:59:59", strtotime("Sunday last week"));
            $sum = Transactions::getTotalMpesaInRangePerCategory($floorDate, $ceilDate,$category_id)['total_mpesa'];
            break;
        case 'lastmonth':
            //$lFloor = date( 'Y-m-1 00:00:00',strtotime('-1 month', time()));
            $lFloor =date('Y-m-d 00:00:00', strtotime('first day of last month'));
            $lCeil = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
            $sum = Transactions::getTotalMpesaInRangePerCategory($lFloor, $lCeil,$category_id)['total_mpesa'];
            break;
        default :   
            $sum1 = Transactions::getTotalRevenuePerCategory($category_id)['total_mpesa'];
            $sum2 = ArchivedMpesaPayments::getTotalRevenuePerStation($category_id)['total_mpesa'];
            $sum=$sum1+$sum2;
        endswitch;
        return $sum;    
    }
   
}
