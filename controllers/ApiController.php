<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
USE app\models\Disbursements;
use app\models\MpesaPayments;
use app\models\Outbox;
use app\models\SentSms;
use Webpatser\Uuid\Uuid;
use app\components\Myhelper;
use app\components\Keys;
class ApiController extends Controller
{
    /*command id comission - SalaryPayment
    *expenses - BusinessPayment
    *winner payments - PromotionPayment
    */
    public function processDisbursementPayment($disbursement_id, $phone_number, $amount, $command_id)
    {
        $access_token = Disbursements::generateTokenB2C();
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
            'SecurityCredential' => Disbursements::setSecurityCredentials(),
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
        $content = json_decode($curl_response,true);
        $conversation_id = $content['ConversationID'];
        $model=Disbursements::findOne($disbursement_id);
        if($model)
        {
            $model->conversation_id=$conversation_id;
            $model->updated_at=date("Y-m-d H:i:s");
            $model->save(false);
        }
        
    }
    public function actionDisbursementPaymentTimeoutResult()
    {
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata,true);
        $conversation_id=$data['ConversationID'];
        $disbursement=Disbursements::find()->where("conversation_id = $conversation_id")->one();
        if($disbursement)
        {
            $disbursement->status=2;
            $disbursement->updated_at= date('Y-m-d H:i:s');
            $disbursement->save(false);
        }
    }
    public function actionDisbursementPaymentResultConfirmation()
    {
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata,true);
        $data=$data['Result'];
        $conversation_id=$data['ConversationID'];
        $transaction_reference=$data['TransactionID'];
        $result_code=$data['ResultCode'];
        $disbursement=Disbursements::find()->where("conversation_id = '$conversation_id'")->one();
        if($disbursement)
        {
            if($result_code===0)
            {
                $disbursement->status=1;
                $disbursement->transaction_reference=$transaction_reference;
                $disbursement->updated_at= date('Y-m-d H:i:s');
                $disbursement->save(false);
            }
            else{
                $disbursement->status=0;
                $disbursement->transaction_reference=$transaction_reference;
                $disbursement->updated_at= date('Y-m-d H:i:s');
                $disbursement->save(false);
            }
            
        }
    }
    public function actionConfirmation()
    {
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata,true);
        $trans_id=$data['TransID'];
        $check=MpesaPayments::find()->where("TransID='$trans_id'")->count();
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
                if($data['TransAmount'] >=100 && $data['TransAmount'] < 300)
                {
                    $message = "$first_name, Umeingia Draw! Endelea Kushiriki, Waweza tunukiwa, PB 5668989 Ksh 100, T&C apply. Customer care  0719034035";
                }
                else
                {
                    $message = "$first_name, Kushiriki kwenye draw ni shilingi mia moja tu,Waweza tunukiwa, PB 5668989 Ksh 100, T&C apply. Customer care  0719034035";

                }
                Outbox::saveOutbox($data['MSISDN'],$message,2);
            }    
        }
        
        
    }
    #code to disburse payments
    public function actionPayout()
    {
        Myhelper::checkRemoteAddress();
        $data=Disbursements::getPendingDisbursement();
        for($i=0;$i<count($data); $i++)
        {
            $row=$data[$i];
            $command_id=Disbursements::getCommandId($row->disbursement_type);    
            $this->processDisbursementPayment($row->id,$row->phone_number,$row->amount,$command_id);
            $row->status=3;
            $row->save(false);
        }
    }
    #start of sms code
    public function sendSms($phone_number,$message)
    {
        $username=Keys::getSmsUsername();
        $password=Keys::getSmsPassword();
        $cookie=Keys::getSmsCookie();
        $data = array('username' => $username,'password' => $password,'oa' => 'nitext','payload' => '[{"msisdn":"'.$phone_number.'","message":"'.$message.'","unique_id":1000}]');
        $data = http_build_query($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => NITEXTSMSURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: $cookie"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }
    public function actionProcessSms()
    {
        Myhelper::checkRemoteAddress();
        $outbox=Outbox::find()->limit(1500)->all();
        for($i=0;$i<count($outbox);$i++)
        {
            $row=$outbox[$i];
            //$this->sendSms($row->receiver,$row->message);
            $sent_sms=new SentSms();
            $sent_sms->receiver=$row->receiver;
            $sent_sms->message=$row->message;
            $sent_sms->category=$row->category;
            $sent_sms->category=$row->category;
            $sent_sms->created_date=$row->created_date;
            $sent_sms->save(false);
            $row->delete(false);
        }
    }
    public function actionSms()
    {
        //$data = file_get_contents('php://input');
        //$filename="/srv/apps/comp21/web/sms.txt";
        //file_put_contents( $filename, $data, FILE_APPEND );
    }
    #end of sms code
    public function beforeAction($action)
    {            
        if (in_array($action->id,array('process-sms','sms','disbursement-payment-result-confirmation','confirmation','disbursement-payment-timeout-result','payout'))) {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }

}
?>