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
        if(in_array(gethostname(),[EFMTZ_COM]))
        {
            Disbursements::tzPayout($this->id,"mshindo");
        }
        if(in_array(gethostname(),[CMEDIA_COTZ]))
        {
            Disbursements::tzPayout($this->id,"mchongo");
        }
        
    }

}
?>