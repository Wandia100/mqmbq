<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_management_stations".
 *
 * @property string $id
 * @property string|null $station_id
 * @property string|null $station_management_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class StationManagementStations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_management_stations';
    }

     /**
        *   Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getStations() {
        return $this->hasOne(Stations::className(), [ 'id' => 'station_id' ] );
    }
     /**
        *   Users relationship
        * @return \yii\db\ActiveQuery
    */
    public function getUsers() {
        return $this->hasOne(Users::className(), [ 'id' => 'station_management_id' ] );
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['station_id', 'station_management_id','unique_field'], 'string', 'max' => 255],
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
            'station_management_id' => 'Station Management ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
