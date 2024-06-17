<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\WinningHistories;
use yii\base\BaseObject;

class AwardsJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        WinningHistories::logDailyAwards();
    }

}
?>