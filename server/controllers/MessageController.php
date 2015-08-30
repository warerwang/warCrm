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
            $where = "cid = '{$cid}' and id < '{$id}'";
        }else{
            $where = ['cid' => $cid];
        }
        return array_reverse(Message::find()->where($where)->limit(50)->orderBy(['id' => SORT_DESC])->all());
    }
} 