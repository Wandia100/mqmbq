<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_show_presenters".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property string|null $presenter_id
 * @property int $is_admin
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class StationShowPresenters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_show_presenters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['is_admin'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'station_show_id', 'presenter_id'], 'string', 'max' => 255],
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
            'station_id' => 'Station ID',
            'station_show_id' => 'Station Show ID',
            'presenter_id' => 'Presenter ID',
            'is_admin' => 'Is Admin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
