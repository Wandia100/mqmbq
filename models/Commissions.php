<?php

namespace app\models;

use Yii;
use app\models\CommissionSummary;
use yii\db\IntegrityException;
/**
 * This is the model class for table "commissions".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property float $amount
 * @property float $transaction_cost
 * @property string|null $transaction_reference
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Commissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commissions';
    }
/**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStations() {
        return $this->hasOne(Stations::className(), [ 'id' => 'station_id' ] );
    }
    
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStationshows(){
        return $this->hasOne(StationShows::className(), ['id' => 'station_show_id']);
    }

    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getUser() {
        return $this->hasOne(Users::className(), [ 'id' => 'user_id' ] );
    }
    
    
    /**
     * Getter for users full name
     * @return string
     */
    public function getFullname() {
        if ( isset( $this->user->first_name ) ) {
                return $this->user->first_name;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['amount', 'transaction_cost'], 'number'],
            [['status','c_type'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'station_show_id', 'transaction_reference'], 'string', 'max' => 255],
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
            'station_id' => 'Station ID',
            'station_show_id' => 'Station Show ID',
            'amount' => 'Amount',
            'transaction_cost' => 'Transaction Cost',
            'transaction_reference' => 'Transaction Ref',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function processedCommission($current_date)
    {
        $resp=array();
        $sql="SELECT DISTINCT(station_show_id) as station_show_id FROM commissions WHERE created_at > :current_date";
        $data=Yii::$app->db->createCommand($sql)
        ->bindValue(':current_date',$current_date)
        ->queryAll();
        for($i=0;$i<count($data);$i++)
        {
            array_push($resp,$data[$i]['station_show_id']);
        }
        return $resp;
    }
    public static function presenterCommission($presenter_id)
    {
        $sql="SELECT c.name AS station_name,d.name AS show_name,b.amount,b.created_at FROM station_show_presenters a
        LEFT JOIN commissions b ON a.station_show_id=b.station_show_id
       LEFT JOIN stations c ON b.station_id=c.id LEFT JOIN station_shows d ON a.station_show_id=d.id
       WHERE b.c_type=3 AND a.presenter_id=:presenter_id";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':presenter_id',$presenter_id)
        ->queryAll();
    }
    public static function commissionSummary($start_date,$end_date)
    {
        $sql='SELECT a.id as station_show_id,a.station_id,b.name AS station_name,a.name AS show_name,CONCAT(a.start_time,"-",a.end_time) AS show_timing,
        a.target,(SELECT COALESCE(SUM(amount),0)  FROM transaction_histories WHERE station_show_id=a.id AND created_at BETWEEN :start_date AND :end_date) AS achieved,
        (SELECT COALESCE(SUM(amount),0) FROM winning_histories WHERE station_show_id=a.id AND created_at BETWEEN :start_date AND :end_date) AS payout,
        (SELECT COALESCE(SUM(amount),0) FROM commissions WHERE c_type=3 AND station_show_id=a.id AND created_at BETWEEN :start_date AND :end_date) AS presenter_commission,
        (SELECT COALESCE(SUM(amount),0) FROM commissions WHERE c_type=5 AND station_show_id=a.id AND created_at BETWEEN :start_date AND :end_date) AS station_commission 
        FROM station_shows a LEFT JOIN stations b ON a.station_id=b.id';
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    public static function logCommission($commission_date)
    {
        $start_time=$commission_date." 00:00";
        $end_time=$commission_date." 23:59";
        $data=Commissions::commissionSummary($start_time,$end_time);
        for($i=0;$i<count($data);$i++)
        {
            $commission=$data[$i];
            $comm=CommissionSummary::checkDuplicate($commission['station_show_id']."-".$commission_date);
            if($comm==NULL)
            {
                    try
                {
                    $model=new CommissionSummary(); 
                    $model->station_name=$commission['station_name'];
                    $model->show_name=$commission['show_name'];
                    $model->show_timing=$commission['show_timing'];
                    $model->station_id=$commission['station_id'];
                    $model->station_show_id=$commission['station_show_id'];
                    $model->target=$commission['target'];
                    $model->achieved=$commission['achieved'];
                    $model->payout=$commission['payout'];
                    $model->net_revenue=round($commission['achieved']-$commission['payout']);
                    $model->presenter_commission=$commission['presenter_commission'];
                    $model->station_commission=$commission['station_commission'];
                    $model->commission_date=$commission_date;
                    $model->unique_field=$commission['station_show_id']."-".$commission_date;
                    $model->save(false);
                }
                catch(IntegrityException $e)
                {
                    //allow execution
                }
            }
            else{
                $comm->target=$commission['target'];
                $comm->achieved=$commission['achieved'];
                $comm->payout=$commission['payout'];
                $comm->net_revenue=round($commission['achieved']-$commission['payout']);
                $comm->presenter_commission=$commission['presenter_commission'];
                $comm->station_commission=$commission['station_commission'];
                $comm->save(false);
            }
            
            

        }
    }
    /**
     * Method to get presenter commission report
     * @param type $start_date
     * @param type $end_date
     * @return type
     */
    public static function getPresenterCommission($start_date,$end_date)
    {
        $sql = "SELECT s.name,concat(u.first_name,u.last_name) AS presentername,u.phone_number,sum(c.amount) AS totalamount
        FROM com21.commissions c
        LEFT JOIN com21.stations s ON c.station_id = s.id
        LEFT JOIN com21.station_show_presenters sp ON sp.station_id = s.id
        LEFT JOIN com21.users u ON sp.presenter_id = u.id
        WHERE u.perm_group = 3 AND c.created_at BETWEEN  :start_date AND :end_date
        GROUP BY s.name,u.first_name,u.last_name,u.phone_number";
        return Yii::$app->analytics_db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
}
