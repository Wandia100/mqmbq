<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\TransactionHistories;
use yii\base\BaseObject;

class LogLoserJob extends BaseObject implements \yii\queue\JobInterface
{
    public $limit;
    public function execute($queue)
    {
        //code to send sms by id
        TransactionHistories::logLoser($this->limit);
    }

}
?>