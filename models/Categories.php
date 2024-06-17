<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property string $id
 * @property string $name
 * @property string|null $vendor
 * @property int $enabled
 * @property string $category_code
 * @property int|null $is_default
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $phone
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'category_code'], 'required'],
            [['enabled', 'is_default'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['name', 'vendor'], 'string', 'max' => 255],
            [['category_code'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 10],
            [['category_code'], 'unique'],
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
            'name' => 'Name',
            'vendor' => 'Vendor',
            'enabled' => 'Enabled',
            'category_code' => 'Category Code',
            'is_default' => 'Is Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'phone' => 'Phone',
        ];
    }
    public static function getCategories(){
        $list = [];
        if(\Yii::$app->myhelper->isStationManager()){
           $records =  Categories::find()->where(['IN','id', \Yii::$app->myhelper->getCategories()])->andWhere(['enabled'=>1])->all();
        }else{
            $records = Categories::findAll(['enabled'=>1]);
        }
        foreach ($records as $record) {
            $list[$record -> id] = $record->name;
        }
        return $list;
    }
   
    public static function getGategoryResult($from_time)
    {
        $response=array();
        $sql="select a.id,a.id as category_id,a.name as category_name,a.name,a.category_code from categories a where a.deleted_at IS NULL order by a.name asc";
        $data= Yii::$app->db->createCommand($sql)
        ->bindValue(':from_time',"%$from_time%")
        ->queryAll();
        for($i=0;$i<count($data); $i++)
        {
            $row=$data[$i];
            $row['amount']=Transactions::getCategoryTotalMpesa($from_time,$row['category_code'])['amount'];
            array_push($response,$row);

        }
        return $response;
    }
    public static function getCategoryTotalResult($start_period,$end_period)
    {
        $sql="select a.id,a.id as category_id,a.name as category_name,a.category_code,
        COALESCE((select sum(b.amount) from transaction b where b.deleted_at IS NULL AND b.created_at >= :start_period and
        b.created_at <= :end_period AND  (SUBSTRING(b.name,1,3)=SUBSTRING(a.category_code,1,3) || RIGHT(b.name,3)=RIGHT(a.category_code,3) || b.name LIKE concat('%',a.category_code,'%'))),0) 
        as amount from categories a where a.deleted_at IS NULL order by a.name asc";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':start_period',$start_period)
        ->bindValue(':end_period',$end_period)
        ->queryAll();
    }
    public static function getDayCategoryTotalResult($the_day)
    {
        $sql="select a.id,a.id as category_id,a.name as category_name,a.category_code,
        COALESCE((select sum(b.amount) from transactions b where b.deleted_at IS NULL AND b.created_at LIKE :the_day  AND  (SUBSTRING(b.name,1,3)=SUBSTRING(a.category_code,1,3) || RIGHT(b.name,3)=RIGHT(a.category_code,3) || b.name LIKE concat('%',a.category_code,'%'))),0) as amount from categories a where a.deleted_at IS NULL order by a.name asc";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':the_day',"%$the_day%")
        ->queryAll();
    }
    public static function getCategory($stat_code)
    {
        $scode=$stat_code;
        $sql="SELECT a.id,a.name,a.category_code FROM categories a 
        WHERE a.deleted_at IS NULL AND  (SUBSTRING(a.category_code,1,3)=SUBSTRING(:stat_code,1,3) || 
        RIGHT(a.category_code,3)=RIGHT(:stat_code,3) || a.category_code LIKE :scode) ";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':stat_code',$stat_code)
        ->bindValue(':scode',"%$scode%")
        ->queryOne();
    }
    public static function getActiveCategories()
    {
        if(\Yii::$app->myhelper->isStationManager()){
           return Categories::find()->where(['IN','id', \Yii::$app->myhelper->getCategories()])->andWhere("deleted_at is null")->orderBy("name asc")->all();
        }else{
            return Categories::find()->where("deleted_at is null")->orderBy("name asc")->all();
        }
        
    }


}
