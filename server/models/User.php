<?php

namespace app\models;

use yii;
use app\components\Tools;
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
    const SCENARIO_EDIT_AVATAR = 'edit_avatar';

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
            'title',
            'phone',
            'avatar' => function(){
                  if(empty($this->avatar)){
                      return [
                          //                          '36' => '/assets/images/default-36.png',
                          //                          '48' => '/assets/images/default-48.png',
                          //                          '150' => '/assets/images/default-150.png',
                          '36'  => Yii::$app->request->hostInfo . '/images/default-36.png',
                          '48'  => Yii::$app->request->hostInfo . '/images/default-48.png',
                          '150' => Yii::$app->request->hostInfo . '/images/default-150.png',
                      ];
                  }else{
                      return [
                          '36' => Tools::getPrivateLink($this->avatar, 'imageView2/2/w/36/q/75'),
                          '48' => Tools::getPrivateLink($this->avatar, 'imageView2/2/w/48/q/75'),
                          '150' => Tools::getPrivateLink($this->avatar),
                      ];
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
                "email","password","did","name","phone","description","title"
            ],
            self::SCENARIO_EDIT => [
                "name","phone","description","title","password"
            ],
            self::SCENARIO_EDIT_PASSWORD => [
                "password"
            ],
            self::SCENARIO_EDIT_AVATAR => [
                "avatar"
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

    public static function createUser ($did, $email, $password, $title = '', $isAdmin = 0, $status = 1)
    {
        $user = new self();
        $user->setScenario(self::SCENARIO_CREATE);
        $user->did = $did;
        $user->email = $email;
        $user->password = $password;
        $user->status = $status;
        $user->isAdmin = $isAdmin;
        $user->title = $title;
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
