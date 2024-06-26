<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "station_show_commissions".
 *
 * @property int $id
 * @property string|null $station_id
 * @property string|null $station_show_id
 * @property int $perm_group
 * @property float $commission
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class StationShowCommissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'station_show_commissions';
    }

    /**
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getPermgroup() {
        return $this->hasOne(PermissionGroup::className(), [ 'id' => 'perm_group' ] );
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perm_group'], 'integer'],
            [['commission'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['station_id', 'station_show_id'], 'string', 'max' => 255],
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
            'perm_group' => 'Perm Group',
            'commission' => 'Commission',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public static function getShowCommission($station_show_id)
    {
        return StationShowCommissions::find()->where("station_show_id='$station_show_id'")->all();
    }
}
