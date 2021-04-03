<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_log".
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $causer_id
 * @property string|null $properties
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 */
class ActivityLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['properties', 'created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['description'], 'string', 'max' => 150],
            [['causer_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'causer_id' => 'Causer ID',
            'properties' => 'Properties',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
