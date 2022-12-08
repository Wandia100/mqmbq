<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Outbox;
use app\models\SentSms;
use yii\base\BaseObject;

class ArchiveJob extends BaseObject implements \yii\queue\JobInterface
{
    public $created_date;
    public function execute($queue)
    {
        //code to send sms by id
       SentSms::archive($this->created_date);
    }

}
?>