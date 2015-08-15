<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/3/3
 * Time: 上午1:10
 */

namespace app\exceptions;

class UserException extends \yii\base\UserException
{
    const PASSWORD_IS_INVALID_CODE = 10001;
    const USER_IS_NOT_EXIST_CODE   = 10002;
    const PERMISSION_DENIED_CODE   = 10003;

    const USER_IS_NOT_EXIST   = '用户不存在';
    const PASSWORD_IS_INVALID = '密码错误';
    const PERMISSION_DENIED   = '权限不足';


    public function getName()
    {
        if($this->code < 20000){
            return '认证错误';
        }else{
            return '错误';
        }
    }
}