<?php

namespace app\models;

use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "customer".
 *
 * @property int $msisdn
 * @property int $total
 * @property string $created_at
 * @property string $updated_at
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['msisdn'], 'required'],
            [['total'], 'integer'],
            [['created_at', 'updated_at','msisdn'], 'safe'],
            [['msisdn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'msisdn' => 'Msisdn',
            'total' => 'Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public static function getCustomer($msisdn)
    {
        return Customer::findOne(['msisdn'=>$msisdn]);
    }
    public static function createCustomer($msisdn,$total)
    {
        try
        {
            $model=new Customer();
            $model->msisdn=$msisdn;
            $model->total=$total;
            $model->save(false);
        }
        catch(IntegrityException $e)
        {
            //do nothing
        }
    }
    public static function customerTicket($msisdn)
    {
        $customer=Customer::getCustomer($msisdn);
        if($customer==NULL)
        {
            $total=TransactionHistories::countEntry($msisdn);
            Customer::createCustomer($msisdn,$total);

        }
        else{
            $total=$customer->total+1;
            $customer->total=$total;
            $customer->updated_at=date("Y-m-d H:i:s");
            $customer->save(false);
        }
        return $total;
    }
}
