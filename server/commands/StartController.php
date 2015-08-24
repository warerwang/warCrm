<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use app\models\Chat;
use app\models\Group;
use yii;
use app\models\Message;
use app\models\User;
use yii\console\Controller;
use Workerman\Worker;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StartController extends Controller
{
    const REQUEST_TYPE_MESSAGE = 1;     //消息
    const REQUEST_TYPE_BROADCAST = 2;   //广播
    const REQUEST_TYPE_IQ = 3;          //请求
    const REQUEST_TYPE_AUTH = 4;        //认证

    const BROADCAST_LOGIN       = 'login';
    const BROADCAST_LOGOUT      = 'logout';
    const BROADCAST_USER_EDIT   = 'user-edit';
    const BROADCAST_USER_ADD    = 'user-add';
    const BROADCAST_USER_REMOVE = 'user-remove';

    static $userConnectionMap = []; // did =>  user_id => connections的二维数组
    static $identities = [];        // connection_id => user的一维数组

    public function actionIndex()
    {
        $ws_worker = new Worker("websocket://0.0.0.0:2345");

        $ws_worker->onConnect = function($connection)
        {
            $connections[] = $connection;
            $data = [
                'type' => 4,
                'message' => 'please Auth',
            ];
            $connection->send(json_encode($data));
        };

        //收到消息
        $ws_worker->onMessage = function($connection, $jsonData)
        {
            $data = json_decode($jsonData, true);
            if(empty($data)){
                Yii::warning('收到的message, 不正确' . $jsonData);
            }
            //验证部分
            if($data['type'] == self::REQUEST_TYPE_AUTH){
                $accessToken = $data['accessToken'];
                if(empty($accessToken)){
                    Yii::warning('accessToken 不能为空.');
                }
                $user = User::findIdentityByAccessToken($accessToken);
                if($user){
                    self::$identities[$connection->id] = $user;
                    if(!isset(self::$userConnectionMap[$user->did])){
                        self::$userConnectionMap[$user->did] = [];
                    }
                    if(!isset(self::$userConnectionMap[$user->did][$user->id])){
                        self::$userConnectionMap[$user->did][$user->id] = [];
                    }
                    self::$userConnectionMap[$user->did][$user->id][] = $connection;
                    //验证通过,
                    $user->changeLoginStatus(User::ONLINE);
                    $this->sendBroadCast($user->did, self::BROADCAST_LOGIN, ['uid' => $user->id]);
                }else{
                    return $this->closeForAuth($connection, 'Auth Fail');
                }
            }else{
                if(!isset(self::$identities[$connection->id])){
                    return $this->closeForAuth($connection, 'Please Auth First');
                }
                /** @var User $current */
                $current = self::$identities[$connection->id];


                if($data['type'] == self::REQUEST_TYPE_MESSAGE){
                    $this->Messagehandler($connection, $current, $data);
                }elseif($data['type'] == 2){


                }elseif($data['type'] == 3){


                }else{

                }
            }
        };

        $ws_worker->onClose = function($connection)
        {
            $connectionId = $connection->id;
            echo "一个连接关闭了" . $connection->id . PHP_EOL;
            if(isset(self::$identities[$connection->id])){
                echo "存在'identities'" . PHP_EOL;
                /** @var User $user */
                $user = self::$identities[$connection->id];
                foreach(self::$userConnectionMap[$user->did] as $uid => $userConnects){
                    if($uid == $user->id){
                        echo "存在'userConnectionMap'" . PHP_EOL;
                        foreach($userConnects as $k => $conn){
                            if($conn->id == $connection->id){
                                echo "存在'connection->id'" . PHP_EOL;
                                $userConnects = &self::$userConnectionMap[$user->did][$uid];
                                $userConnects[$k] = null;
                                unset($userConnects[$k]);
                                if(count($userConnects) == 0){
                                    //所有连接都被关闭了.
                                    $user->changeLoginStatus(0);
                                    $this->sendBroadCast($user->did, self::BROADCAST_LOGOUT, ['uid' => $user->id]);
                                    echo "存在'count 0'" . PHP_EOL;
                                }else{
                                    echo "仍然有连接" . count($userConnects) . PHP_EOL;
                                    //用户还有其他的连接.
                                }
                            }
                        }
                    }
                }

                //todo 移除掉 $userConnectionMap里的Conn

                self::$identities[$connectionId] = null;
                unset(self::$identities[$connectionId]);

            }
        };
        // Run worker
        Worker::runAll();
    }

    private function closeForAuth ($connection, $message)
    {
        $data = [
            'type' => self::REQUEST_TYPE_AUTH,
            'message' => $message,
        ];
        $connection->close(json_encode($data));
    }

    /**
     * @param         $connection
     * @param Message $message
     * @param array   $extraData
     */
    private function sendMessage ($connection, $message , $extraData = [])
    {
        $responseData = [
            'type'      => self::REQUEST_TYPE_MESSAGE,
            'message'   => $message->attributes,
            'extraData' => $extraData
        ];
        $connection->send(json_encode($responseData));
    }

    /**
     * 发送广播
     *
     * @param String  $did       所要发送广播的域名的id
     * @param  String $message   广播的内容(一般定义成一个key)
     * @param array   $extraData 额外的数据
     *
     * @return bool
     */
    private function sendBroadCast ($did, $message, $extraData = [])
    {
        if(!self::$userConnectionMap[$did]){
            return false;
        }
        $users = self::$userConnectionMap[$did];

        $responseData = [
            'type'      => self::REQUEST_TYPE_BROADCAST,
            'message'   => $message,
            'extraData' => $extraData
        ];
        foreach($users as $uid => $connections){
            foreach($connections as $connection){
                $connection->send(json_encode($responseData));
            }
        }
    }

    /**
     * @param \Workerman\Connection\ConnectionInterface $connection
     * @param User $current
     * @param Array $data
     */
    private function Messagehandler ($connection, $current, $data)
    {
        $chat_id = $data['cid'];
        //没有-是一个group聊天, 否则是一个一对一聊天
        if(strpos($chat_id, '-') === false){
            $isGroup = true;
            /** @var Group $group */
            $group = Group::findOne($chat_id);
            if(empty($group)){
                //todo
                Yii::warning('group ');
            }
            $chatMembers = json_decode($group->members);
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
        $message = $current->sendMessage($chat_id, $data['content']);

        foreach($chatMembers as $uid){
            //增加一条未读消息
            if($current->id != $uid){
                /** @var Chat $chat */
                $chat = $isGroup ? Chat::findOrCreateGroupChat($group->id, $uid) :  Chat::findOrCreate1Chat($current->id, $uid);
                $chat->unReadCount++;
                $chat->save();
            }
            if(!isset(self::$userConnectionMap[$current->did][$uid])) continue;
            foreach(self::$userConnectionMap[$current->did][$uid] as $conn){
                $this->sendMessage($conn, $message);
            }
        }
    }

}