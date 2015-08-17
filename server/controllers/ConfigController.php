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

class ConfigController extends RestController
{
    public $safeActions = ['index'];

    public function actionIndex ($subDomain = null)
    {
        return Domain::find()->where(['domain' => $subDomain])->one();
    }
} 