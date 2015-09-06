<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/16
 * Time: 下午7:14
 */

namespace app\models;

use yii;
use app\models\base\ChatsBase;

class Chat extends ChatsBase
{
    const CHAT_TYPE_1_ON_1 = 1;
    const CHAT_TYPE_GROUP  = 2;

    public function beforeValidate ()
    {
        if($this->isNewRecord){
            $this->createTime = (new \DateTime())->format("Y-m-d H:i:s");
        }
        $this->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
        return true;
    }

    public static function getChat ($id, $uid)
    {
        return Chat::find()->where(['uid' => $uid, 'id' => $id])->one();
    }

    /**
     * 查找或新建一个一对一对话
     * @param integer $id  对话另一方用户 id
     * @param integer $uid 对话所属用户的 Id
     * @param integer $did 域名id
     *
     * @return Chat|array|null|yii\db\ActiveRecord
     * @throws yii\web\NotFoundHttpException
     */
    public static function findOrCreate1Chat ($id, $uid, $did)
    {
        $chat = self::getChat($id, $uid);
        if(empty($chat)){
            $user = User::findOne(['id' => $id, 'did' => $did]);
            if(empty($user) || $user->id == $uid){
                throw new yii\web\NotFoundHttpException("用户不存在，可能已经被删除了。");
            }
            $chat = self::create1Chat($id, $uid);
        }
        return $chat;
    }

    /**
     * 查找或新建一个群组对话
     * @param integer $id  群组id
     * @param integer $uid 对话所属的用户Id
     * @param integer $did 域名id
     *
     * @return Chat|array|null|yii\db\ActiveRecord
     * @throws yii\web\NotFoundHttpException
     */
    public static function findOrCreateGroupChat ($id, $uid, $did)
    {
        $chat = self::getChat($id, $uid);
        if(empty($chat)){
            $group = Group::findOne(['id' => $id, 'did' => $did]);
            if(empty($group)){
                throw new yii\web\NotFoundHttpException("群组不存在，可能已经被删除了。");
            }else{
                $members = json_decode($group['members'], true);
                if(!in_array($uid, $members)){
                    throw new yii\web\NotFoundHttpException("没有权限加入这个群组。");
                }
            }
            $chat = self::createGroupChat($id, $uid);
        }
        return $chat;
    }

    public static function create1Chat($id, $uid)
    {
        $chat = new self();
        $chat->id = $id;
        $chat->uid = $uid;
        $chat->type = self::CHAT_TYPE_1_ON_1;
        $chat->save();
        return $chat;
    }

    public static function createGroupChat($id, $uid)
    {
        $chat = new self();
        $chat->id = $id;
        $chat->uid = $uid;
        $chat->type = self::CHAT_TYPE_GROUP;
        $chat->save();
        return $chat;
    }
}