<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission".
 *
 * @property int $id
 * @property string|null $name
 * @property int $status active= 1 or inactive = 0
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'status' => 'Status',
        ];
    }
    

	/**
	 * Function to get permissions in an array.
	 */
	public static function getPermissions() {
		$arr = [];
		$mod = Permission::find()->where( "status = 1" )->all();
		foreach ( $mod as $value ) {
			$arr[ $value->id ] = $value->name . '(' . $value->id . ') ';
		}

		return $arr;
	}
}
