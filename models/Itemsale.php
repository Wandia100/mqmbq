<?php

namespace app\models;

use Webpatser\Uuid\Uuid;
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
class Itemsale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $howmany;
    public $MoneyReceived;
    public $Balance;
    public $modeofpayment;
    public $totalprice;
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
            [['howmany','Balance','modeofpayment','totalprice','MoneyReceived'], 'safe'],
            [['howmany','modeofpayment','totalprice'], 'required'],
            [['category_id', 'name', 'generate_barcode', 'item_code'], 'string', 'max' => 255],
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
            'category_id' => 'Category ID',
            'name' => 'Name',
            'description' => 'Description',
            'generate_barcode' => 'Barcode',
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
    public static function CompleteSale($id)
    {
        $model = Itemsale::findOne($id);
    
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Calculate total price
            $model->totalprice = $model->outprice * $model->howmany;
    
            $transaction = new Transactions();
            $transaction->id = Uuid::generate()->string;
            $transaction->user_id = Yii::$app->user->id;
            $transaction->amount = $model->totalprice;
            $transaction->category_item_id = $model->id;
            $transaction->category_id = $model->category_id;
            $transaction->name = $model->name;
            $transaction->description = $model->name;
            $transaction->mode_payment = $model->modeofpayment;
            $transaction->quantity = $model->howmany;
            $transaction->item_code = $model->item_code;
            $transaction->generate_barcode = $model->generate_barcode;
    
            if ($transaction->save(false)) {
                // Update the quantity in the category_items table
                Yii::$app->db->createCommand()
                    ->update('category_items', 
                        ['quantity' => new \yii\db\Expression('quantity - :howMany')], 
                        ['id' => $transaction->category_item_id]
                    )
                    ->bindValue(':howMany', $model->howmany)
                    ->execute();
    
                // Delete all items from the basket table
                Yii::$app->db->createCommand()->delete('basket')->execute();
            }
        }
    }
}
    
