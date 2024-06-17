<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winner_summary".
 *
 * @property int $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property string|null $station_name
 * @property string|null $show_name
 * @property string|null $prize_name
 * @property string|null $prize_id
 * @property string|null $show_timing
 * @property int|null $awarded
 * @property string|null $winning_date
 * @property string|null $unique_field
 */
class WinnerSummary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profit_summary';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profit'], 'integer'],
            [['transaction_date'], 'safe'],
            [['category_id', 'category_item_id'], 'string', 'max' => 36],
            [['category_name'], 'string', 'max' => 50],
            [['item_name'], 'string', 'max' => 50],
            [['unique_field'], 'string', 'max' => 500],
            [['unique_field'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'category_item_id' => 'Category Item ID',
            'category_name' => 'Category Name',
            'item_name' => 'Item Name',
            'profit' => 'Profit',
            'transaction_date' => 'Transaction Date',
            'unique_field' => 'Unique Field',
        ];
    }
    public static function getProfitSummary($start_date,$end_date)
    {
        $sql="select category_name,item_name,profit,sum(profit) as profit from profit_summary
        where ";
        if(\Yii::$app->myhelper->isStationManager()){
            $categories = implode(",", array_map(function($string) {
               return '"' . $string . '"';
            }, \Yii::$app->myhelper->getCategories()));
            $sql .=" `category_id` IN ($categories) AND ";
        }
        $sql.="transaction_date between :start_date and :end_date
        group by category_name,item_name,profit";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    public static function checkDuplicate($unique_field)
    {
        return WinnerSummary::find()->where("unique_field='$unique_field'")->one();
    }
}
