<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "returnedBack".
 *
 * @property string $id
 * @property string $category_item_id
 * @property string $name
 * @property int $howmany
 * @property float $outprice
 * @property int $enabled
 */
class ReturnedBack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'returnedBack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_item_id', 'name', 'howmany', 'outprice'], 'required'],
            [['howmany', 'enabled'], 'integer'],
            [['outprice'], 'number'],
            [['id'], 'string', 'max' => 36],
            [['category_item_id', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_item_id' => 'Category Item ID',
            'name' => 'Name',
            'howmany' => 'Howmany',
            'outprice' => 'Outprice',
            'enabled' => 'Enabled',
        ];
    }
    public function getReturnedBack()
{
    return $this->hasMany(ReturnedBack::class, ['category_item_id' => 'id']);
}
public function getCategoryItem()
{
    return $this->hasOne(CategoryItems::class, ['id' => 'category_item_id']);
}

}
