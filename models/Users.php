<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $national_id
 * @property string|null $date_of_birth
 * @property string|null $phone_number
 * @property string $email
 * @property string|null $profile_image
 * @property int $perm_group
 * @property string|null $defaultpermissiondenied
 * @property string|null $extpermission
 * @property string $password
 * @property int $enabled
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $created_by
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name', 'email', 'password'], 'required'],
            [['date_of_birth', 'created_at', 'updated_at','deleted_at','defaultpermissiondenied', 'extpermission'], 'safe'],
            [['perm_group', 'enabled'], 'integer'],
            [['id', 'created_by'], 'string', 'max' => 36],
            [['first_name', 'last_name', 'profile_image'], 'string', 'max' => 50],
            [['national_id', 'phone_number'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [[], 'string', 'max' => 55],
            [['password'], 'string', 'max' => 255],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'national_id' => 'National ID',
            'date_of_birth' => 'Date Of Birth',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'profile_image' => 'Profile Image',
            'perm_group' => 'Perm Group',
            'defaultpermissiondenied' => 'Defaultpermissiondenied',
            'extpermission' => 'Extpermission',
            'password' => 'Password',
            'enabled' => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
    
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
       $dbuser = Users::find()
            ->where([
                "email" => $username
            ])
           ->one();
        if(!$dbuser){
            return null;
        }
        return new static($dbuser);
    }
    public static function getPresenterShowCount($presenter_id)
    {
        $shows = Yii::$app->db->createCommand('SELECT count(id) as total FROM station_show_presenters WHERE presenter_id=:presenter_id AND deleted_at IS NULL')
           ->bindValue(':presenter_id',$presenter_id)
           ->queryOne();
        return  $shows['total']; 
    }
}
