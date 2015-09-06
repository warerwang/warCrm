<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

use \GatewayWorker\Lib\Gateway;
use app\models\Attach;
use app\models\Chat;
use app\models\Group;
use app\models\Message;
use app\models\User;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 *
 * GatewayWorker开发参见手册：
 * @link http://gatewayworker-doc.workerman.net/
 */
class Event
{
    const REQUEST_TYPE_MESSAGE = 1;     //消息
    const REQUEST_TYPE_BROADCAST = 2;   //广播
    const REQUEST_TYPE_IQ = 3;          //请求
    const REQUEST_TYPE_AUTH = 4;        //认证

    const BROADCAST_LOGIN = 'user-login';
    const BROADCAST_LOGOUT = 'user-logout';
    const BROADCAST_USER_EDIT = 'user-edit';
    const BROADCAST_USER_ADD = 'user-add';
    const BROADCAST_USER_REMOVE = 'user-remove';

    public static $broadcastList = [
        self::BROADCAST_LOGIN,
        self::BROADCAST_LOGOUT,
        self::BROADCAST_USER_EDIT,
        self::BROADCAST_USER_ADD,
        self::BROADCAST_USER_REMOVE,
    ];

    public static function onConnect($client_id)
    {
        echo "一个新的连接接入：" . $client_id;
        $data = [
            'type' => self::REQUEST_TYPE_AUTH,
            'message' => 'Please Auth',
        ];
        $_SESSION['current_client_id'] = $client_id;
        Gateway::sendToCurrentClient(json_encode($data));
    }

   public static function onMessage($client_id, $jsonData)
   {
       $data = json_decode($jsonData, true);
       if(empty($data)){
           Yii::warning('收到的message, 不正确' . $jsonData);
       }
       //验证部分
       if($data['type'] == self::REQUEST_TYPE_AUTH){
           if(!isset($data['accessToken']) || empty($data['accessToken'])){
               Yii::warning('accessToken 不能为空.');
               Gateway::closeCurrentClient();
           }
           $accessToken = $data['accessToken'];
           $user = User::findIdentityByAccessToken($accessToken);
           if($user){
               /** @var \app\components\GlobalData $globalData */
               $globalData = Yii::$app->globalData;
               $globalData->setIdentity($client_id, $user);
               //绑定在当前域名下
               Gateway::bindUid($client_id, $user->did);
               $globalData->addClientToUser($client_id, $user->id);
               echo "用户" . $user->name . ', ID: ' . $user->id . '登录成功';
               $clients = $globalData->getClientsByUserId($user->id);
               echo "存在" . count($clients). '个登录连接。'.PHP_EOL;
               //验证通过,
               $user->changeLoginStatus(User::ONLINE);
               self::sendBroadCast($user->did, self::BROADCAST_LOGIN, $user->toArray());
           }else{
               self::closeForAuth('Auth Fail');
           }
       }else{
           /** @var User $current */
           $current = Yii::$app->globalData->getIdentity($_SESSION['current_client_id']);
           if(empty($current)){
               self::closeForAuth('Please Auth First');
               return false;
           }

           if($data['type'] == self::REQUEST_TYPE_MESSAGE){
               self::MessageHandler($data);
           }elseif($data['type'] == self::REQUEST_TYPE_BROADCAST){
               if(!in_array($data['message'], self::$broadcastList)){
                   Yii::warning("未知的广播, " . $data['message'] . ', 用户id: ' . $current->id . ', 用户名： ' . $current->name);
                   return false;
               }
               echo "发送广播" . $data['message'] . '用户id: ' . $current->id . 'Did: ' . $current->did . ' 用户名： '. $current->name . PHP_EOL;
               self::sendBroadCast($current->did, $data['message'], $data['data']);
           }elseif($data['type'] == 3){


           }else{

           }
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       /** @var \app\components\GlobalData $globalData */
       $globalData = Yii::$app->globalData;
       $user = $globalData->getIdentity($client_id);
       echo "一个连接关闭了" . $client_id ;
       echo "用户名： " . $user->name . PHP_EOL;
       if(empty($user)){
           Yii::warning("onClose, 没有Identity, Client_id:" . $client_id);
       }

       $globalData->removeIdentity($client_id);
       $clients = $globalData->getClientsByUserId($user->id);
       if(empty($clients)){
           $user->changeLoginStatus(0);
           self::sendBroadCast($user->did, self::BROADCAST_LOGOUT, $user->toArray());
       }
   }


    private static function sendBroadCast ($did, $message, $data = [])
    {
        $responseData = [
            'type'      => self::REQUEST_TYPE_BROADCAST,
            'message'   => $message,
            'data'      => $data
        ];
        GateWay::sendToUid($did, json_encode($responseData));
    }

    private static function closeForAuth ($message)
    {
        $data = [
            'type' => self::REQUEST_TYPE_AUTH,
            'message' => $message,
        ];
        Gateway::sendToCurrentClient(json_encode($data));
        Gateway::closeCurrentClient();
    }

    private static function MessageHandler ($data)
    {
        $chat_id = $data['cid'];
        /** @var User $current */
        $current = Yii::$app->globalData->getIdentity($_SESSION['current_client_id']);
        //没有-是一个group聊天
        if(strpos($chat_id, '-') === false){
            $isGroup = true;
            /** @var Group $group */
            $group = Group::findOne($chat_id);
            if(empty($group)){
                //todo
                Yii::error('Group 不存在, chat_id' . $chat_id);
                return;
            }
            $chatMembers = json_decode($group->members);
        //否则是一个一对一聊天
        }else{
            $isGroup = false;
            $chatMembers = explode('-', $data['cid']);
            if(count($chatMembers) > 2){

                //todo
            }
            if($chatMembers[0] == $chatMembers[1]){
                unset($chatMembers[1]);
            }
            //todo 这里需要验证用户是否存在.
        }
        if(isset($data['extra'])){
            if(isset($data['extra']['type'])){
                self::extraDataHandler($data['extra']);
            }
        }else{
            $data['extra'] = [];
        }
        $message = $current->sendMessage($chat_id, $data['content'], $data['extra']);
        /** @var \app\components\GlobalData $globalData */
        $globalData = Yii::$app->globalData;
        foreach($chatMembers as $uid){
            //不是本人的话，增加一条未读消息
            if($current->id != $uid){
                /** @var Chat $chat */
                $chat = $isGroup ? Chat::findOrCreateGroupChat($group->id, $uid, $current->did) :  Chat::findOrCreate1Chat($current->id, $uid, $current->did);
                $chat->unReadCount++;
                $chat->save();
            }
            $clients = $globalData->getClientsByUserId($uid);
            foreach($clients as $client_id){
                self::sendMessage($client_id, $message);
            }
        }
    }

    /**
     * @param $extraData
     */
    private static function extraDataHandler($extraData)
    {
        if(empty($extraData)) return;
        /** @var User $current */
        $current = Yii::$app->globalData->getIdentity($_SESSION['current_client_id']);
        if($extraData['type'] == 'attach'){
            $attach = new Attach();
            $attach->load($extraData['data'], '');
            $attach->did = $current->did;
            if(!$attach->save()){
                Yii::error("保存数据出错" . $attach->getFirstErrorContent());
            }
        }
    }

    /**
     * @param         $client_id
     * @param Message $message
     * @param array   $extraData
     */
    private static function sendMessage ($client_id, $message , $extraData = [])
    {
        $responseData = [
            'type'      => self::REQUEST_TYPE_MESSAGE,
            'message'   => $message->toArray(),
            'extraData' => $extraData
        ];
        Gateway::sendToClient($client_id, json_encode($responseData));
    }
}
