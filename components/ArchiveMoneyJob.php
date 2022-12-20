<?php
/*send sms code using queue*/
namespace app\components;

use app\models\MpesaPayments;
use Yii;
use app\models\Outbox;
use app\models\SentSms;
use yii\base\BaseObject;

class ArchiveMoneyJob extends BaseObject implements \yii\queue\JobInterface
{
    public $created_at;
    public $limit;
    public function execute($queue)
    {
        //code to send sms by id
       MpesaPayments::archive($this->created_at,$this->limit);
    }

}
?>