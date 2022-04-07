<?php
/*send sms code using queue*/
namespace app\components;

use app\models\HourlyPerformanceReports;
use Yii;
use app\models\MpesaPayments;
use yii\base\BaseObject;

class LastHourJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        //code to send sms by id
        HourlyPerformanceReports::LastHour();
    }

}
?>