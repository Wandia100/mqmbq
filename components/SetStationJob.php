<?php
/*send sms code using queue*/
namespace app\components;

use app\models\MpesaPayments;
use yii\base\BaseObject;

class SetStationJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        MpesaPayments::setStation();
    }

}
?>