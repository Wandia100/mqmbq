<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "basket".
 *
 * @property string $id
 * @property string $user_id
 * @property string $category_id
 * @property string $category_item_id
 * @property string $name
 * @property string|null $description
 * @property string $item_code
 * @property string $mode_payment
 * @property float $amount
 * @property int $quantity
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $generate_barcode
 */
class Basket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $balance;
    public $money_given;
    public $totalprice;
    public static function tableName()
    {
        return 'basket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'category_item_id', 'name', 'item_code', 'mode_payment', 'amount', 'quantity'], 'required'],
            [['description', 'mode_payment'], 'string'],
            [['amount'], 'number'],
            [['quantity','quantityToReturn'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['balance','money_given','totalprice'], 'safe'],
            [['user_id', 'category_id', 'category_item_id', 'name', 'item_code'], 'string', 'max' => 255],
            [['item_code'], 'unique'],
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
            'category_id' => 'Category ID',
            'category_item_id' => 'Category Item ID',
            'name' => 'Name',
            'description' => 'Description',
            'item_code' => 'Item Code',
            'mode_payment' => 'Mode Payment',
            'amount' => 'Amount',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Relation to CategoryItem model
     */
    public function getCategoryItem()
    {
        return $this->hasOne(CategoryItems::class, ['id' => 'category_item_id']);
    }
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
