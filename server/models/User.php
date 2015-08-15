<?php

namespace app\models;

use app\models\base\UsersBase;
use yii\web\IdentityInterface;

class User extends UsersBase implements IdentityInterface
{

    const EXPIRE_TIME = 3600;
    public static function findIdentity ($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken ($token, $type = null)
    {
        $user = self::find()->andWhere(['accessToken' => $token])->andWhere('lastActivity	> ' . (time() - self::EXPIRE_TIME))->one();
        return $user;
    }

    public function getId ()
    {
        return $this->id;
    }

    public function getAuthKey ()
    {

    }

    public function validateAuthKey ($authKey)
    {

    }

    public function validatePassword($password)
    {
        return true;
    }
}
