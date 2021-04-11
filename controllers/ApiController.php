<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
USE app\models\Disbursements;

class ApiController extends Controller
{
    /*command id comission - SalaryPayment
    *expenses - BusinessPayment
    *winner payments - PromotionPayment
    */
    public function processDisbursementPayment($disbursement_id, $phone_number, $amount, $command_id)
    {
        $access_token = $this->generateTokenB2C();
        $CommandID = $command_id;
        $PartyA = PARTYA;
        $Remarks = REMARKS;
        $QueueTimeOutURL = QUEUETIMEOUTURL;
        $ResultURL = RESULTURL;
        $InitiatorName = INITIATORNAME;
        $Occasion = OCCASION;
        $url = MPESAPAYMENTREQUESTURL;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '. $access_token));

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'InitiatorName' => $InitiatorName,
            'SecurityCredential' => $this->setSecurityCredentials(),
            'CommandID' => $CommandID,
            'Amount' => $amount,
            'PartyA' => $PartyA,
            'PartyB' => $phone_number,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
            'Occasion' => $Occasion
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);

        $content = json_decode($curl_response);
        $conversation_id = $content->ConversationID;
        $model=Disbursements::findOne($conversation_id);
        $model->conversation_id=$conversation_id;
        $model->updated_at=date("Y-m-d H:i:s");
        $model->save(false);
    }
    public function actionDisbursementPaymentTimeoutResult()
    {}
    public function generateTokenB2C()
    {

        $url = MPESATOKENURL;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $app_consumer_key = file_get_contents("/srv/credentials/mpesaapp_consumer_key.txt");
        $app_consumer_secret = file_get_contents("/srv/credentials/mpesaapp_consumer_secret.txt");
        $credentials = base64_encode($app_consumer_key.':'.$app_consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $token_info=json_decode($curl_response,true);
        return $token_info['access_token'];

    }
    public function setSecurityCredentials ()
    {
        $publicKey =file_get_contents("/srv/credentials/mpesa_public_key.txt");
        $plaintext =file_get_contents("/srv/credentials/mpesaplaintext.txt");
        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }
   

}
?>