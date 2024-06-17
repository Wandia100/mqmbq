<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_items".
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string|null $description
 * @property string|null $generate_barcode
 * @property string $item_code
 * @property float $inprice
 * @property float $outprice
 * @property int $quantity
 * @property float $target
 * @property int $enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class CategoryItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'name', 'item_code', 'inprice', 'outprice', 'quantity'], 'required'],
            [['description'], 'string'],
            [['inprice', 'outprice', 'target'], 'number'],
            [['quantity', 'enabled'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['category_id','generate_barcode','name', 'item_code'], 'string', 'max' => 255],
            [['item_code','generate_barcode'], 'unique'],
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
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'generate_barcode' => 'Generate Barcode',
            'item_code' => 'Item Code',
            'inprice' => 'Inprice',
            'outprice' => 'Outprice',
            'quantity' => 'Quantity',
            'target' => 'Target',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function getCategories() {
        return $this->hasOne(Categories::className(), [ 'id' => 'category_id' ] );
    }
    
    public static function getCategoryItems() {
        $arr   = [];
        
        if(\Yii::$app->myhelper->isStationManager()){
            $categories = implode(",", array_map(function($string) {
               return '"' . $string . '"';
            }, \Yii::$app->myhelper->getStations()));
            $model = CategoryItems::find()->where("category_id IN ($categories)")->orderBy("name ASC")->all();
        }
        else
        {
            $model = CategoryItems::find()->orderBy("name ASC")->all();
        }
        foreach ( $model as $value ) {
            $arr[ $value->id ] = $value->name;
        }
        return $arr;
   }
   public static function getCategoryItemsSummary($start_date,$end_date)
    {
        $sql="SELECT a.id,a.category_id,a.name AS category_item_name,b.name AS category_name,
        COALESCE((SELECT SUM(amount) FROM transactions WHERE category_item_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_revenue,
         FROM category_items a LEFT JOIN categories b ON a.category_id=b.id 
         WHERE a.deleted_at IS NULL AND a.enabled=1 ORDER BY total_revenue DESC";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    public static function getPayin($start_date,$end_date)
    {
        $sql="SELECT a.id,a.category_id,a.name AS category_item_name,b.name AS category_name,
        COALESCE((SELECT SUM(inprice) FROM transactions WHERE category_item_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_payin
         FROM category_itemss a LEFT JOIN categories b ON a.station_id=b.id 
         WHERE a.deleted_at IS NULL AND a.enabled=1 ";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }
    public static function getPayout($start_date,$end_date)
    {
        $sql="SELECT a.id,a.category_id,a.name AS category_item_name,b.name AS category_name,
        COALESCE((SELECT SUM(amount) FROM transactions WHERE category_item_id=a.id AND deleted_at IS NULL AND created_at BETWEEN :start_date AND :end_date),0) AS total_payout
         FROM category_items a LEFT JOIN categories b ON a.category_id=b.id 
         WHERE a.deleted_at IS NULL AND a.enabled=1 ";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_date',$start_date)
        ->bindValue(':end_date',$end_date)
        ->queryAll();
    }        
}
