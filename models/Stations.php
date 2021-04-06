<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stations".
 *
 * @property string $id
 * @property string $name
 * @property string|null $address
 * @property int $enabled
 * @property string $station_code
 * @property float $invalid_percentage
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Stations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'station_code'], 'required'],
            [['enabled'], 'integer'],
            [['invalid_percentage'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['name', 'address'], 'string', 'max' => 255],
            [['station_code'], 'string', 'max' => 100],
            [['station_code'], 'unique'],
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
            'address' => 'Address',
            'enabled' => 'Enabled',
            'station_code' => 'Station Code',
            'invalid_percentage' => 'Invalid Percentage',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    /**
     * Method to getPermission group list
     * @return type
     */
    public static function getStations(){
        $list = [];
        $records = Stations::findAll(['enabled'=>1]);
        foreach ($records as $record) {
            $list[$record -> id] = $record->name;
        }
        return $list;
    }
}
