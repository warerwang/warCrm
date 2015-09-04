<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/3/3
 * Time: 上午1:29
 */

namespace app\components;

use yii;
use yii\base\Component;

class GlobalData extends Component
{

    public function setIdentity ($client_id, $user)
    {
        $cache = Yii::$app->cache;
        $cache->set('identities' . $client_id,  $user);
    }

    public function getIdentity ($client_id)
    {
        $cache = Yii::$app->cache;
        return $cache->get('identities' . $client_id);
    }

    public function removeIdentity ($client_id)
    {
        $cache = Yii::$app->cache;
        $user = $this->getIdentity($client_id);
        if(!empty($user)){
            $cache->delete('identities' . $client_id);
            $clients = $this->getClientsByUserId($client_id);
            unset($clients[array_search($client_id, $clients)]);
            $cacheKey = 'userConnectionMap_' . $user->id;
            if(count($clients) > 0){
                $cache->set($cacheKey, $clients);
            }else{
                $cache->delete($cacheKey);
            }
        }
    }

    public function addClientToUser($client_id, $user_id)
    {
        $cache = Yii::$app->cache;
        $cacheKey = 'userConnectionMap_' . $user_id;
        if($cache->exists($cacheKey)){
            $userConnectionMap = $cache->get($cacheKey);
        }else{
            $userConnectionMap = [];
        }
        $userConnectionMap[] = $client_id;
        $cache->set($cacheKey, $userConnectionMap);
    }

    /**
     * @param $user_id
     *
     * @return array|mixed
     */
    public function getClientsByUserId ($user_id)
    {
        $cache = Yii::$app->cache;
        $cacheKey = 'userConnectionMap_' . $user_id;
        $clients = $cache->get($cacheKey);
        if(empty($clients)){
            $clients = [];
        }
        return $clients;
    }


} 