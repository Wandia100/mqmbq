<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financial_summaries".
 *
 * @property string $id
 * @property float $mpesa_today
 * @property float $mpesa_total
 * @property float $transaction_history_today
 * @property float $transaction_history_total
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class FinancialSummaries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financial_summaries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['mpesa_today', 'mpesa_total', 'transaction_history_today', 'transaction_history_total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
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
            'mpesa_today' => 'Mpesa Today',
            'mpesa_total' => 'Mpesa Total',
            'transaction_history_today' => 'Transaction History Today',
            'transaction_history_total' => 'Transaction History Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
