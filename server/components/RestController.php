<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/1/29
 * Time: 下午11:17
 */

namespace app\components;

use yii\filters\Cors;
use yii\rest\Controller;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class RestController extends Controller
{
    const DB_ERROR            = 100000;
    const PASSWORD_IS_INVALID = 100001;
    const USER_IS_NOT_EXIST   = 100002;
    const PERMISSION_DENIED   = 100003;

    public $safeActions = [];
    public $errorMessage = [
        self::DB_ERROR            => "数据库操作错误",
        self::PASSWORD_IS_INVALID => "用户不存在",
        self::USER_IS_NOT_EXIST   => "密码错误",
        self::PERMISSION_DENIED   => "权限不足",
    ];

    public function behaviors ()
    {
        $behaviors = parent::behaviors();
        if ($this->action->id != 'options' && !in_array($this->action->id, $this->safeActions)) {
            $behaviors['authenticator'] = [
                'class'       => CompositeAuth::className(),
                'authMethods' => [
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ],
            ];
        }
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];

        return $behaviors;
    }

    public function actionOptions ()
    {
        return ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH'];
    }
} 