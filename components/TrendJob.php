<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\MpesaPayments;
use app\models\PlayerTrend;
use yii\base\BaseObject;

class TrendJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        //code to send sms by id
        PlayerTrend::logTrend();
    }

}
?>