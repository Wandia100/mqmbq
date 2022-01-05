<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loser".
 *
 * @property int $id
 * @property string|null $reference_name
 * @property string $reference_phone
 * @property int $plays
 * @property string $created_at
 * @property string|null $deleted_at
 */
class Loser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loser';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('analytics_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_phone'], 'required'],
            [['plays'], 'integer'],
            [['created_at', 'deleted_at'], 'safe'],
            [['reference_name'], 'string', 'max' => 50],
            [['reference_phone'], 'string', 'max' => 12],
            [['reference_phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reference_name' => 'Reference Name',
            'reference_phone' => 'Reference Phone',
            'plays' => 'Plays',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
