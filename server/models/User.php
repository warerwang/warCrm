<?php

namespace app\models;

use app\models\base\UsersBase;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Query;
use yii\web\IdentityInterface;

class User extends UsersBase implements IdentityInterface
{
    const EXPIRE_TIME = 3600;
    public static function findIdentity ($id)
    {
        return self::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null  $type
     *
     * @return static
     */
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

    public function sendMessage ($cid, $content, $extraData = [])
    {
        return Message::create($cid, $content, $this->id, $this->did, $extraData);
    }

    public function beforeValidate ()
    {
        if(parent::beforeValidate()){
            $this->salt = strval(rand(100000, 999999));
            $this->password = md5($this->password . $this->salt);
            $this->accessToken = md5(microtime(true) . $this->salt);
            $this->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
            return true;
        }else{
            return false;
        }
    }

    public static function createUser ($did, $email, $password)
    {
        $user = new self();
        $user->did = $did;
        $user->email = $email;
        $user->password = $password;
        if($user->save()){
            return $user;
        }else{
            print_r($user->errors);die;
            throw new Exception('');
        }
    }
}
