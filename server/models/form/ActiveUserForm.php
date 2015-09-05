<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-4
 * Time: 下午11:53
 */

namespace app\models\form;


use app\components\Tools;
use app\models\User;

class ActiveUserForm extends User
{
    /** @var User */
    public $user;
    public function activeUser()
    {
        $this->createTime = Tools::getDateTime();
        $this->lastActivity = Tools::getDateTime();
        $this->status = 1;
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}