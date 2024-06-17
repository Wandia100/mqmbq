<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Commissions;
use yii\base\BaseObject;

class CommissionJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        //code to send sms by id
        Commissions::process();
    }

}
?>