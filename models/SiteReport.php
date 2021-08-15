<?php

namespace app\models;

use app\models\MpesaPayments;
use app\models\WinningHistories;
use Yii;

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
        return Yii::$app->get('analytics_db');
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
        
        foreach ($ReportNames as $value) {
            if(in_array($value, $payInReportName)){
                $sum = MpesaPayments::getMpesaCounts($value);
            }else if($value == 'yesterday_payout'){
                $sum = WinningHistories::getPayout(date("Y-m-d",strtotime("yesterday")))['total'];
            }
            $model = SiteReport::find()->where("report_name = '$value'")->one();
            if(!$model){
                $model = new SiteReport();
            }
            $model -> report_name = $value;
            $model -> report_value = $sum;
            $model -> report_date = date('Y-m-d H:i:s');
            $model ->save(FALSE);
        }
    }
    /**
     * Method to get site report
     * @param type $reportName
     */
    public static function getSiteReport($reportName){
        $model = SiteReport::find()->where("report_name = '$reportName'")->one();
        if($model){
            return $model->report_value;
        }
        return 0;
    }
}
