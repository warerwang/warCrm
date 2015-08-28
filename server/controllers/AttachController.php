<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/28
 * Time: 下午9:21
 */

namespace app\controllers;


use app\components\RestController;
use app\models\Attach;

class AttachController extends RestController
{
    public function actionIndex ($cid)
    {
        $did = \Yii::$app->user->identity->did;
        return Attach::findAll(['did' => $did,'chatId' => $cid]);
    }
}