<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
USE app\models\Disbursements;
use app\models\MpesaPayments;
use app\models\Outbox;
use Webpatser\Uuid\Uuid;

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
    public function actionConfirmation()
    {
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata,true);
        $trans_id=$data['TransID'];
        $check=MpesaPayments::find()->where("TransID=$trans_id")->count();
        if($check==0)
        {
            $model = new MpesaPayments();
            $model->id=Uuid::generate()->string;
            $model->TransID = $data['TransID'];
            $model->FirstName = $data['FirstName'];
            $model->MiddleName = $data['MiddleName'];
            $model->LastName = $data['LastName'];
            $model->MSISDN = $data['MSISDN'];
            $model->InvoiceNumber = $data['InvoiceNumber'];
            $model->BusinessShortCode = $data['BusinessShortCode'];
            $model->ThirdPartyTransID = $data['ThirdPartyTransID'];
            $model->TransactionType = $data['TransactionType'];
            $model->OrgAccountBalance = $data['OrgAccountBalance'];
            $model->BillRefNumber = strtoupper(str_replace(' ', '', $data['BillRefNumber']));
            $model->TransAmount = $data['TransAmount'];
            $model->created_at=date("Y-m-d H:i:s");
            $model->updated_at=date("Y-m-d H:i:s");
            if($model->save(false))
            {
                $first_name=$data['FirstName'];
                $message = "$first_name, Umeingia Draw! Endelea Kushiriki, Wa weza tunukiwa, PB 5668989 Ksh 100, T&C apply. Customer care  0719034035";
                Outbox::saveOutbox($data['MSISDN'],$message,2);
            }    
        }
        
        
    }
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