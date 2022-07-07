<?php
/*send sms code using queue*/
namespace app\components;

use app\models\HourlyPerformanceReports;
use Yii;
use app\models\MpesaPayments;
use yii\base\BaseObject;

class LastHourJob extends BaseObject implements \yii\queue\JobInterface
{
    public $the_day;
    public $hr;
    public function execute($queue)
    {
        //code to send sms by id
        
        HourlyPerformanceReports::LastHour($this->the_day,$this->hr);
    }

}
?>