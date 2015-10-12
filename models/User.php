<?php
namespace app\models;
use Yii;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public static function tableName()
    {
        return 'user';
    }
    public static function getUserName($user_id){
        return Yii::$app->db->createCommand('SELECT username FROM user WHERE id = "'.$user_id.'"')
        ->queryColumn()[0];
    }
}