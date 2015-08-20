<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/16
 * Time: 下午7:12
 */

namespace app\controllers;

use app\components\RestController;
use app\models\Domain;
use Yii;
use yii\web\NotFoundHttpException;

class ConfigController extends RestController
{
    public $safeActions = ['index'];

    public function actionIndex ($subDomain = null)
    {
        $domain = Domain::findOne(['domain' => $subDomain]);
        if(!$domain){
            throw new NotFoundHttpException("域名不存在");
        }
        return $domain;
    }
} 