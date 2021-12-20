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
use app\components\DepositJob;
use yii\db\IntegrityException;

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
        if(isset($content['ConversationID']))
        {
            $conversation_id = $content['ConversationID'];
            $model=Disbursements::findOne($disbursement_id);
            if($model)
            {
                $model->conversation_id=$conversation_id;
                $model->updated_at=date("Y-m-d H:i:s");
                $model->save(false);
            }
        }
        else
        {
            $filename="/srv/apps/comp21/web/mpesa.txt";
            $data=$curl_response;
            file_put_contents( $filename, $data,FILE_APPEND);
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
            try
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
                $model->save(false);
                Yii::$app->queue->push(new DepositJob(['id'=>$data->TransID]));
            }
            catch (IntegrityException $e) {
                //allow execution
            }
   
        }
        
        //Yii::$app->response->data = json_encode($data);
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
    }
    public function actionValidation()
    {
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata,true);
        if($data['TransAmount']==100)
        {
            $resp['ResultCode']=0;
            $resp['ResultDesc']="Accepted";
        }
        else
        {
            $resp['ResultCode']=1;
            $resp['ResultDesc']="Rejected";
        }
        //\Yii::$app->response->data = json_encode($response);
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $resp;
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
            $row->status=3;
            $row->save(false);
            $this->processDisbursementPayment($row->id,$row->phone_number,$row->amount,$command_id);
            
        }
    }
    #start of sms code
    public function sendSms($payload)
    {
        $username=Keys::getSmsUsername();
        $password=Keys::getSmsPassword();
        $cookie=Keys::getSmsCookie();
        $data = array('username' => $username,'password' => $password,'oa' => 'nitext','payload' => json_encode($payload));
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
        $count=Outbox::find()->count();
        $batch_size=50;
        $rounds=ceil($count/$batch_size);
        for($i=0; $i<$rounds; $i++)
        {
            $payload=Outbox::getOutbox();
            $this->sendSms($payload);
        }
    }
    public function actionTzsms()
    {
        Myhelper::checkRemoteAddress();
        $sender_name="MSHINDO";

        $smses=Outbox::getOutbox();
        for($i=0; $i<count($smses); $i++)
        {
            $payload=$smses[$i];
            $channel=Myhelper::getSmsChannel($payload['msisdn']);
            Myhelper::sendTzSms($payload['msisdn'],$payload['message'],$sender_name,$channel);
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
        if (in_array($action->id,array('process-sms','sms','disbursement-payment-result-confirmation','confirmation','validation','disbursement-payment-timeout-result','payout'))) {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }

}
?>