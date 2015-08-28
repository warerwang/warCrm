<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/28
 * Time: 上午1:57
 */

namespace app\models;


use app\components\Tools;
use app\models\base\AttachmentsBase;

class Attach extends AttachmentsBase
{
    public function fields ()
    {
        $fields = parent::fields();
        unset($fields['did']);
        $fields['isImg'] = function($data){
            return Tools::isImg($data['ext']);
        };
        $fields['url'] = function($data){
            if(Tools::isImg($data['ext'])){
                return [
                    'source' => Tools::getPrivateLink($data['key']),
                    'small'  => Tools::getPrivateLink($data['key'], 'small'),
                    'middle'  => Tools::getPrivateLink($data['key'], 'middle'),
                    'big'  => Tools::getPrivateLink($data['key'], 'big'),
                ];
            }else{
                return [
                    'source' => Tools::getPrivateLink($data['key'])
                ];
            }
        };
        return $fields;
    }
}