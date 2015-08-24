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
        $request = Yii::$app->request;
        $chat = Chat::find()->where(['uid' => $uid, 'id' => $id])->one();
        if(empty($chat)){
            throw new yii\web\NotFoundHttpException('不存在');
        }
        $data    = json_decode($request->rawBody, true);
        //todo 设置一个 scenario
        $chat->load($data, '');
        $chat->save(false);
        return $chat;
    }

    public function actionView ($id, $type)
    {
        $uid = Yii::$app->user->identity->id;
        if($type == Chat::CHAT_TYPE_1_ON_1){
            $chat = Chat::findOrCreate1Chat($id, $uid);
        }else{
            $chat = Chat::findOrCreateGroupChat($id, $uid);
        }
        return $chat;
    }

    public function actionDelete($id)
    {
        $uid = Yii::$app->user->identity->id;
        Chat::deleteAll(['uid' => $uid, 'id' => $id]);
        return true;
    }
}