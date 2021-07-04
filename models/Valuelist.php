<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valuelist".
 *
 * @property int $id
 * @property string $type
 * @property string $value
 * @property string|null $index
 * @property int $status
 */
class Valuelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'valuelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 25],
            [['value'], 'string', 'max' => 250],
            [['index'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'value' => 'Value',
            'index' => 'Index',
            'status' => 'Status',
        ];
    }
   
    /**
        * Function to get valuelist given type
        * @param integer $type type of value list
        * @return array
    */
   public static function getValuelistByType( $type) {
        $arr   = [];
        $model = ValueList::find()->where( [ 'type' => $type, 'status' => 1 ] )->all();
        foreach ( $model as $value ) {
            $arr[ $value->index ] = $value->value;
        }
        return $arr;
   }
   
    /**
        * Method to get value by key
        *
        * @param integer $key value list key
        * @param string $type valuelist type
        * @return string valuelist val
    */
   public static function getValue( $key, $type) {
        $model = ValueList::find()->where( [ 'type' => $type, 'index' => $key ] )->one();
        if ( $model ) {
            return $model->value;
        }
   }
    
}
