<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\ShowSummary;
use yii\base\BaseObject;

class ShowSummaryJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        //code to send sms by id
        ShowSummary::logShowSummary();
    }

}
?>