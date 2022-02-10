<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Disbursements;
use yii\base\BaseObject;

class TzPayoutJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public $product;
    public function execute($queue)
    {
        //code to send sms by id
        Disbursements::tzPayout($this->id,$this->product);
    }

}
?>
