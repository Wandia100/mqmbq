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
        * Customer - Stations relationship
        * @return \yii\db\ActiveQuery
    */
    public function getUser() {
        return $this->hasOne(Users::className(), [ 'id' => 'presenter_id' ] );
    }
    
    
    /**
     * Getter for users full name
     * @return string
     */
    public function getFullname() {
        if ( isset( $this->user->first_name ) ) {
                return $this->user->first_name.' '.$this->user->last_name;
        }
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
    public static function presenterStationShow($presenter_id,$current_day)
    {
        $sql="SELECT b.station_id,c.frequency,a.station_show_id,b.name AS show_name,c.name as station_name,b.description,b.show_code,b.jackpot,
        b.target,b.start_time,b.end_time,a.is_admin,a.presenter_id 
        FROM station_show_presenters a LEFT JOIN station_shows b ON a.station_show_id=b.id 
        LEFT JOIN stations c ON b.station_id=c.id 
        WHERE a.presenter_id=:presenter_id AND b.enabled=1 AND b.".$current_day."=1
        AND  start_time <=CURTIME()  AND end_time >=CURTIME()";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':presenter_id',$presenter_id)
        ->queryOne();
    }
    public static function adminStationShow($station_show_id,$current_day)
    {
        $sql="SELECT b.station_id,c.frequency,a.station_show_id,b.name AS show_name,c.name as station_name,b.description,b.show_code,b.jackpot,
        b.target,b.start_time,b.end_time,a.is_admin,a.presenter_id 
        FROM station_show_presenters a LEFT JOIN station_shows b ON a.station_show_id=b.id 
        LEFT JOIN stations c ON b.station_id=c.id 
        WHERE a.station_show_id=:station_show_id AND a.is_admin=1 AND b.enabled=1 AND b.".$current_day."=1";
        return Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->queryOne();
    }
    public static function jackpotShow($station_show_id)
    {
        $sql="SELECT a.station_id,c.frequency,a.id as station_show_id,a.name AS show_name,c.name as station_name,a.description,a.show_code,a.jackpot,
        a.target,a.enabled as is_admin
        FROM station_shows a 
        LEFT JOIN stations c ON a.station_id=c.id 
        WHERE a.id=:station_show_id  AND a.enabled=1 AND a.jackpot=1";
        $resp= Yii::$app->db->createCommand($sql)
        ->bindValue(':station_show_id',$station_show_id)
        ->queryOne();
        $resp['presenter_id']=Yii::$app->user->identity->id;
        return $resp;
    }
    public static function getShowAdmin($station_show_id)
    {
        return StationShowPresenters::find()->where(['station_show_id'=>$station_show_id,'is_admin'=>1])->one();
    }
}
