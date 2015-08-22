<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/23
 * Time: 上午12:47
 */

namespace app\controllers;

use yii;
use app\components\RestController;
use app\models\Chat;

class ChatController extends RestController
{
    public function actionIndex ()
    {
        $uid = Yii::$app->user->identity->id;
        return Chat::find()->where(['uid' => $uid])->addOrderBy([ 'lastActivity' => SORT_DESC])->limit(25)->all();
    }

    public function actionUpdate ($id)
    {
        $uid = Yii::$app->user->identity->id;

        $chat = Chat::find()->where(['uid' => $uid, 'id' => $id])->one();
//        $chat->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
        $chat->save();
        return $chat;
    }

    public function actionView ($id)
    {
        $uid = Yii::$app->user->identity->id;
        $chat = Chat::find()->where(['uid' => $uid, 'id' => $id])->one();
        if(empty($chat)){
            $chat = Chat::create1Chat($id, $uid);
        }
        return $chat;
    }
}