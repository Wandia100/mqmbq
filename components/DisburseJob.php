<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Disbursements;
use yii\base\BaseObject;

class DisburseJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public function execute($queue)
    {
        //code to send sms by id
        if(in_array(gethostname(),[COMP21_COKE,COMP21_DEV,COMP21_NET]))
        {
            Disbursements::safaricomPayout($this->id);
        }
        
    }

}
?>