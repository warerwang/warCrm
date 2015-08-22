<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/16
 * Time: 下午7:14
 */

namespace app\models;


use app\models\base\ChatsBase;

class Chat extends ChatsBase
{

    public function beforeValidate ()
    {
        if($this->isNewRecord){
            $this->createTime = (new \DateTime())->format("Y-m-d H:i:s");
        }
        $this->lastActivity = (new \DateTime())->format("Y-m-d H:i:s");
        return true;
    }

    public static function create1Chat($id, $uid)
    {
        $chat = new self();
        $chat->id = $id;
        $chat->uid = $uid;
        $chat->type = 1;
        $chat->save();
        return $chat;
    }

    public static function createGroupChat($id, $uid)
    {
        $chat = new self();
        $chat->id = $id;
        $chat->uid = $uid;
        $chat->type = 2;
        $chat->save();
        return $chat;
    }

}