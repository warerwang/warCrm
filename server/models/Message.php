<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/16
 * Time: 下午7:14
 */

namespace app\models;


use app\models\base\MessagesBase;

class Message extends MessagesBase
{
    public static function create($cid, $content, $sender, $did, $extraData = [])
    {
        $message = new self();
        $message->cid = $cid;
        $message->content = $content;
        $message->sender = $sender;
        $message->did = $did;
        $message->extraData = json_encode($extraData);
        $message->save();
        return $message;
    }

} 