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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT   = 'edit';
    const SCENARIO_EDIT_PASSWORD = 'edit_password';

    const ONLINE = 1;
    const OFFLINE = 0;
    const BUSY = 2;

    public static function findIdentity ($id)
    {
        return self::findOne($id);
    }

    public function fields ()
    {
        return [
            'id',
            'name',
            'email',
            'loginStatus',
            'nickName',
            'phone',
            'avatar' => function(){
                  if(empty($this->avatar)){
                      return 'http://cdn.v2ex.com/gravatar/'.md5($this->email).'.png?default=mm';
                  }else{
                      return $this->avatar;
                  }
                },
            'description',
            'did',
            'isAdmin',
            'createTime',
            'lastActivity',
            'status',
            'loginStatus'
        ];
    }

    public function scenarios(){
        return [
            self::SCENARIO_CREATE => [
                "email","password","did","name","phone","avatar","description","nickName"
            ],
            self::SCENARIO_EDIT => [
                "name","phone","avatar","description","nickName"
            ],
            self::SCENARIO_EDIT_PASSWORD => [
                "password"
            ],
        ];
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
        if($user){
            $user->updateActivityTime();
        }
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
        return $this->password == md5($password . $this->salt);
    }

    public function sendMessage ($cid, $content, $extraData = [])
    {
        return Message::create($cid, $content, $this->id, $this->did, $extraData);
    }

    public function beforeValidate ()
    {
        if(parent::beforeValidate()){
            if ($this->isNewRecord) {
                $this->salt = strval(rand(100000, 999999));
                $this->password = md5($this->password . $this->salt);
                $this->accessToken = md5(microtime(true) . $this->salt);
                $this->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
            }else{
                if(!empty($this->password)){
                    $this->salt = strval(rand(100000, 999999));
                    $this->password = md5($this->password . $this->salt);
                }else{
                    $this->password = $this->oldAttributes['password'];
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public static function createUser ($did, $email, $password, $nickName = '', $status = 0)
    {
        $user = new self();
        $user->did = $did;
        $user->email = $email;
        $user->password = $password;
        $user->status = $status;
        $user->nickName = $nickName;
        if($user->save()){
            return $user;
        }else{
            throw new Exception('');
        }
    }

    public function updateActivityTime ()
    {
        $this->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
        $this->save(false);
    }

    public function changeLoginStatus ($status)
    {
        $this->loginStatus = $status;
        $this->save(false);
    }
}
