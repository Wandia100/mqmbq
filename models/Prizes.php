<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prizes".
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property int $mpesa_disbursement
 * @property int $enabled
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Prizes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['mpesa_disbursement', 'enabled','enable_tax'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['name', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'mpesa_disbursement' => 'Mpesa Disbursement',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    
    /**
     * Method to prizes  list
     * @return type
     */
    public static function getPrizesList($permgroup = ''){
        $list = [];
        $records = Prizes::findAll(['enabled'=>1]);
        foreach ($records as $record) {
            $list[$record -> id] = $record->name;
        }
        return $list;
    }
}
