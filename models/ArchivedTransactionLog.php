<?php

namespace app\models;

use Yii;
use Webpatser\Uuid\Uuid;
use yii\db\IntegrityException;
use app\models\CmediaPayments;
use app\components\CmediaPaymentJob;
use app\components\CmediaDepositJob;
/**
 * This is the model class for table "transaction_log".
 *
 * @property int $id
 * @property string $json_data
 * @property string $date
 * @property string|null $api_type
 */
class ArchivedTransactionLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_log';
    }
    public static function getDb() {
        return Yii::$app->cmedia_mpesa;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['json_data', 'date'], 'required'],
            [['json_data'], 'string'],
            [['state'], 'integer'],
            [['date'], 'safe'],
            [['api_type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'json_data' => 'Json Data',
            'date' => 'Date',
            'api_type' => 'Api Type',
        ];
    }
    public static function getPendingTransaction()
    {
        return ArchivedTransactionLog::find()->where("state=0")->all();
    }
    public static function validationResponse($record,$spid,$spPassword)
    {
        $request=json_decode($record->json_data)->request;
        $timestamp=date('YmdHis');
        $serviceDate=date("Y-m-d H:i:s",strtotime($timestamp));
        $initiator="ibm_in";
        $initiatorPassword="24NGiZuATISn=+widndaULALANVLJIYn99CCNbQ1421994";
        $encryptedPasswordProvider = base64_encode(hash("sha256", $spid.$spPassword.$timestamp, True));
        if($request->transaction->amount == 1000)
            {
               $resultType='Completed';
               $resultCode=0;
               $resultDesc='Successful';
            }
            else
            {
                $resultType='failed';
                $resultCode=999;
                $resultDesc='failure';
            }
        return '<?xml version="1.0" encoding="UTF-8"?>
        <mpesaBroker xmlns="http://inforwise.co.tz/broker/" version="2.0">
        <result>
        <serviceProvider>
        <spId>'.$spid.'</spId>
        <spPassword>'.$encryptedPasswordProvider.'</spPassword>
        <timestamp>'.$timestamp.'</timestamp>
         </serviceProvider>
         <transaction>
        <resultType>'.$resultType.'</resultType>
        <resultCode>'.$resultCode.'</resultCode>
        <resultDesc>'.$resultDesc.'</resultDesc>
        <serviceReceipt>'.$request->transaction->mpesaReceipt.'</serviceReceipt>
        <serviceDate>'.$serviceDate.'</serviceDate>
        <originatorConversationID>'.$request->transaction->originatorConversationID.'</originatorConversationID>
        <conversationID>'.$request->transaction->conversationID.'</conversationID>
        <transactionID>'.$request->transaction->transactionID.'</transactionID>
        <initiator>'.$initiator.'</initiator>
        <initiatorPassword>'.$initiatorPassword.'</initiatorPassword>
         </transaction>
        </result>
        </mpesaBroker>';
    }
    public static function saveMpesa($record)
    {
        
        $data=json_decode($record->json_data)->request->transaction;
        $receipt=$data->mpesaReceipt;
        $check=CmediaPayments::find()->where("TransID='$receipt'")->count();
        if($check==0)
        {
            try
            {
                $model = new CmediaPayments();
                $model->id=Uuid::generate()->string;
                $model->TransID = $data->mpesaReceipt;
                //$model->FirstName = $data['FirstName'];
                //$model->MiddleName = $data['MiddleName'];
                //$model->LastName = $data['LastName'];
                $model->MSISDN = $data->initiator;
                //$model->InvoiceNumber = $data['InvoiceNumber'];
                $model->BusinessShortCode = $data->recipient;
                //$model->ThirdPartyTransID = $data['125189974'];
                //$model->TransactionType = $data['TransactionType'];
                //$model->OrgAccountBalance = $data['OrgAccountBalance'];
                $model->BillRefNumber =$data->accountReference;
                $model->TransAmount = $data->amount;
                $model->created_at=$data->transactionDate;
                $model->updated_at=date("Y-m-d H:i:s");
                $model->save(false);
                Yii::$app->cmediaqueue->push(new CmediaDepositJob(['id'=>$model->id]));
            }
            catch (IntegrityException $e) {
                //allow execution
            }
   
        }
    }
    public static function updateState($resp,$record)
    {
        if($resp->response->serviceStatus=='Confirming')
            {
                ArchivedTransactionLog::saveMpesa($record);
                $record->state=1;
                $record->save();
            }
            else
            {
                $record->state=1;
                $record->save();
            }
    }
    public static function saveTransactionLog($xmlData,$api_type,$state)
    {
            $model=new ArchivedTransactionLog();
            $model->json_data=json_encode($xmlData);
            $model->api_type=$api_type;
            $model->date=date("Y-m-d H:i:s");
            $model->state=$state;
            $model->save(false);
            Yii::$app->cmediaqueue->priority(10)->push(new CmediaPaymentJob(['id'=>$model->id]));
    }
    public static function log($data,$api_type,$state)
    {
            $model=new ArchivedTransactionLog();
            $model->json_data=$data;
            $model->api_type=$api_type;
            $model->date=date("Y-m-d H:i:s");
            $model->state=$state;
            $model->save(false);
    }
}
