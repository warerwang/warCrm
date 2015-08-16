<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/16
 * Time: 下午7:12
 */

namespace app\controllers;

use app\components\RestController;
use app\models\Message;

class MessageController extends RestController
{
    public function actionIndex ($cid)
    {

        return Message::find()->where(['cid' => $cid])->all();
    }
} 