<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expenses".
 *
 * @property string $id
 * @property string $user_id
 * @property float $amount
 * @property string $reason
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Expenses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount', 'reason'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id', 'user_id'], 'string', 'max' => 36],
            [['reason'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    // public static function getPayout($the_day)
    // {
    //     if(\Yii::$app->myhelper->isStationManager())
    //     {
    //         $stations = implode(",", array_map(function($string) {
    //             return '"' . $string . '"';
    //             }, \Yii::$app->myhelper->getStations()));
    //         $sql="SELECT COALESCE(SUM(amount),0) AS total FROM transactions WHERE 
    //         created_at LIKE :the_day AND station_id IN ($stations)";        
    //     }
    //     else
    //     {
    //         $sql="SELECT COALESCE(SUM(amount),0) AS total FROM transactions WHERE 
    //      created_at LIKE :the_day";
    //     }
        
    //     return Yii::$app->db->createCommand($sql)
    //     ->bindValue(':the_day',"%$the_day%")
    //     ->queryOne();
    // }
}
