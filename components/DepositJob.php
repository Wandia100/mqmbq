<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\TransactionHistories;
use yii\base\BaseObject;

class DepositJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public function execute($queue)
    {
        //code to send sms by id
        TransactionHistories::processPayment($this->id);
    }

}
?>