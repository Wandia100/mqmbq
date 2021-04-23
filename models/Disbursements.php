<?php

namespace app\models;

use Yii;
use Webpatser\Uuid\Uuid;
use app\components\Keys;
use yii\db\IntegrityException;

/**
 * This is the model class for table "disbursements".
 *
 * @property string $id
 * @property string|null $reference_id
 * @property string|null $reference_name
 * @property string|null $phone_number
 * @property float $amount
 * @property string|null $conversation_id
 * @property int $status
 * @property string|null $disbursement_type
 * @property string|null $transaction_reference
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Disbursements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disbursements';
    }
    
    /**
     * Getter for users full name
     * @return string
     */
    public function getFullname() {
        if ( isset( $this->user->first_name ) ) {
                return $this->user->first_name;
        }
    }
    
    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getUser() {
        return $this->hasOne(Users::className(), [ 'id' => '' ] );
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','amount','disbursement_type','phone_number','reference_name'], 'required'],
            [['amount'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['unique_field'], 'string', 'max' => 50],
            [['reference_id', 'disbursement_type', 'transaction_reference'], 'string', 'max' => 100],
            [['reference_name', 'phone_number', 'conversation_id'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Reference ID',
            'reference_name' => 'Reference Name',
            'phone_number' => 'Phone Number',
            'amount' => 'Amount',
            'conversation_id' => 'Conversation ID',
            'status' => 'Status',
            'disbursement_type' => 'Disbursement Type',
            'transaction_reference' => 'Transaction Reference',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function saveDisbursement($reference_id,$reference_name,$phone_number,$amount,$disbursement_type,$status)
    {
        
        try {
            $model=new Disbursements();
            $model->id=Uuid::generate()->string;
            $model->reference_id=$reference_id;
            $model->reference_name=$reference_name;
            $model->phone_number=$phone_number;
            $model->amount=$amount;
            $model->status=$status;
            $model->unique_field=$phone_number.$amount.date('YmdHi');
            $model->disbursement_type=$disbursement_type;
            $model->created_at=date("Y-m-d H:i:s");
            $model->save(false);
        } catch (IntegrityException $e) {
            //allow execution
        }
        
    }
    public static function getPendingDisbursement()
    {
        return Disbursements::find()->where("status=0")->orderBy("created_at ASC")->all();
    }
    public static  function generateTokenB2C()
    {

        $url = MPESATOKENURL;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $app_consumer_key = Keys::getMpesaConsumerKey();
        $app_consumer_secret = Keys::getMpesaConsumerSecret();
        $credentials = base64_encode($app_consumer_key.':'.$app_consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $token_info=json_decode($curl_response,true);
        return $token_info['access_token'];

    }
    public static function setSecurityCredentials ()
    {
        $publicKey =Keys::getMpesaPublicKey();
        $plaintext =Keys::getMpesaPlainText();
        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }
    /*command id comission - SalaryPayment
    *expenses - BusinessPayment
    *winner payments - PromotionPayment
    */ 
    public static function getCommandId($disbursement_type)
    {
        switch($disbursement_type)
        {
            case "winning":
                $command_id="PromotionPayment";
                break;
            case "commission":
                $command_id="SalaryPayment";
                break;
            case "presenter_commission":
                $command_id="SalaryPayment";
                break;
            case "management_commission":
                $command_id="SalaryPayment";
                break;
            case "expenses":
                $command_id="BusinessPayment";
                break;
            default:
                $command_id="PromotionPayment";
                break;
        }
        return $command_id;
    }
    public static function checkDuplicate($reference_id,$phone_number,$amount)
    {
        return Disbursements::find()->where("reference_id='$reference_id'")
        ->andWhere("phone_number=$phone_number")
        ->andWhere("amount=$amount")->count();
    }
    public static function getDuplicates()
    {
        $sql='SELECT COUNT(unique_field) AS total,unique_field FROM disbursements  GROUP BY unique_field HAVING(total > 1)  LIMIT  10000';
        return Yii::$app->db->createCommand($sql)
        ->queryAll();
    }
    public static function removeDups($unique_field,$limits)
    {
        $sql='DELETE FROM disbursements WHERE unique_field=:unique_field LIMIT :limits';
        Yii::$app->db->createCommand($sql)
        ->bindValue(':unique_field',$unique_field)
        ->bindValue(':limits',$limits)
        ->execute();
    }
}
