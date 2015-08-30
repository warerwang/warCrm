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
    public function actionIndex ($cid, $id = null)
    {
        if($id){
            return array_reverse(Message::find()->where("cid = '{$cid}' and id < '{$id}'")->orderBy(['id' => SORT_DESC])->limit(5)->all());
        }else{
            return array_reverse(Message::find()->where(['cid' => $cid])->limit(5)->orderBy(['id' => SORT_DESC])->all());
        }
    }
} 