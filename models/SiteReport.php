<?php

namespace app\models;

use app\models\Transactions;
use app\models\WinningHistories;
use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "site_report".
 *
 * @property int $id
 * @property string|null $report_name
 * @property int|null $report_value
 * @property string|null $report_date
 */
class SiteReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_report';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_value'], 'integer'],
            [['report_date'], 'safe'],
            [['report_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_name' => 'Report Name',
            'report_value' => 'Report Value',
            'report_date' => 'Report Date',
        ];
    }
    /**
        * Method to set site report
    */
    public static function setSiteReport(){
        $ReportNames = ['yesterday','last_7_days','currentmonth','lastweek','lastmonth','totalrevenue','today_payout','yesterday_payout'];
        $payInReportName = ['yesterday','last_7_days','currentmonth','lastweek','lastmonth','totalrevenue'];
        $categories=Categories::getActiveCategories();
        //SiteReport::deleteAll(false);
        for($i=0;$i< count($categories); $i++)
        {
            $category=$categories[$i];
            foreach ($ReportNames as $value) {
                if(in_array($value, $payInReportName)){
                    $sum = Transactions::getMpesaCountsPerCategory($value,$category->id);
                }else if($value == 'yesterday_payout'){
                    $sum = Transactions::getPayoutPerCategory(date("Y-m-d",strtotime("yesterday")),$category->id)['total'];
                }
                try{
                    $unique_field=$category->id.$value;
                    $model = SiteReport::find()->where("unique_field = '$unique_field'")->one();
                    if(!$model){
                        $model = new SiteReport();
                    }
                    $model -> category_id = $category->id;
                    $model -> report_name = $value;
                    $model -> report_value = $sum;
                    $model -> unique_field = $unique_field;
                    $model -> report_date = date('Y-m-d H:i:s');
                    $model ->save(FALSE);
                }
                catch(IntegrityException $e)
                {
                    //do nothing
                }
                
            }
        }
        
    }
    /**
     * Method to get site report
     * @param type $reportName
     */
    public static function getSiteReport($reportName){
        if(\Yii::$app->myhelper->isStationManager())
        {
            $categories = implode(",", array_map(function($string) {
                return '"' . $string . '"';
                }, \Yii::$app->myhelper->getStations()));
            $sql="select COALESCE(sum(report_value),0) as report_value from 
                    site_report where report_name = '$reportName' AND category_id IN ($categories)";        
        }
        else
        {
            $sql="select COALESCE(sum(report_value),0) as report_value from 
            site_report where report_name = '$reportName'";
        }
        /*$model = SiteReport::find()->where("report_name = '$reportName'")->one();
        if($model){
            return $model->report_value > 0 ? $model->report_value: 0;
        }*/
        return Yii::$app->db->createCommand($sql)
        ->queryOne()['report_value'];
    }
}
