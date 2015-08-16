<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

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
    public function actionIndex()
    {
        global $identities, $userConnectionMap, $connectionMap;
        $identities = [];
        $userConnectionMap = [];
        $ws_worker = new Worker("websocket://0.0.0.0:2345");

        $ws_worker->onConnect = function($connection)
        {
            global $connection_count;
            $connections[] = $connection;
            $data = [
                'type' => 4,
                'message' => 'please Auth',
            ];
            $connection->send(json_encode($data));
        };

        // Emitted when data received
        $ws_worker->onMessage = function($connection, $jsonData)
        {
            global $userConnectionMap, $identities, $connectionMap;
            $data = json_decode($jsonData, true);

            if($data['type'] == 4){
                $accessToken = $data['accessToken'];
                $user = User::findIdentityByAccessToken($accessToken);
                if($user){
                    $identities[$connection->id] = $user;
                    if(!isset($userConnectionMap[$user->id])){
                        $userConnectionMap[$user->id] = [];
                    }
                    $userConnectionMap[$user->id][] = $connection;
//                    $connectionMap[$connection->id] = $connection;
                }else{
                    $data = [
                        'type' => 4,
                        'message' => 'please Auth',
                    ];
                    $connection->close(json_encode($data));
                }
            }else{
                if(!isset($identities[$connection->id])){
                    $data = [
                        'type' => 4,
                        'message' => 'please Auth',
                    ];
                    $connection->close(json_encode($data));
                }
                /** @var User $current */
                $current = $identities[$connection->id];
                if($data['type'] == 1){
                    $message = $current->sendMessage($data['cid'], $data['content']);

                $senderUsers = explode('-', $data['cid']);
                $responseData = [
                    'type' => 1,
                    'message' => $message->attributes,
                ];
                foreach($senderUsers as $uid){
                    if(!isset($userConnectionMap[$uid])) continue;
                    foreach($userConnectionMap[$uid] as $conn){
                        print_r($responseData);
                        $conn->send(json_encode($responseData));
                    }
                }

                }elseif($data['type'] == 2){


                }elseif($data['type'] == 3){


                }else{

                }
            }
        };


        $ws_worker->onClose = function($connection)
        {
            global $identities, $userConnectionMap;
            if(isset($identities[$connection->id])){
                $user = $identities[$connection->id];
                //todo 移除掉 $userConnectionMap里的Conn

                $identities[$connection->id] = null;
                unset($identities[$connection->id]);

            }
        };
        // Run worker
        Worker::runAll();
    }
}