<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permission_group".
 *
 * @property int $id
 * @property string $name Name of the permission group
 * @property int $status group status (active= 1 inactive=0)
 * @property string|null $defaultPermissions
 */
class PermissionGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permission_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status','has_permission'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['defaultPermissions'], 'string', 'max' => 600],
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
            'defaultPermissions' => 'Default Permissions',
        ];
    }
    /**
     * Method to getPermission group list
     * @return type
     */
    public static function getPermissionGroup(){
        $list = [];
        $records = PermissionGroup::findAll(['status'=>1]);
        foreach ($records as $record) {
            $list[$record -> id] = $record->name;
        }
        return $list;
    }
}
