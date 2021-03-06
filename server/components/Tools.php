<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/3/3
 * Time: 上午1:29
 */

namespace app\components;


use DateTime;
use DateTimeZone;
use Yii;

class Tools
{

//    /**
//     * @param \yii\base\Model $model
//     */
//    public static function getFirstError ($model)
//    {
//        foreach ($model->getErrors() as $error) {
//            return $error[0];
//        }
//    }

    public static function getDateTime($returnTimeStamp = false)
    {
        $dateTime = new \DateTime();
        if($returnTimeStamp){
            return $dateTime->getTimestamp();
        }else{
            return $dateTime->format("Y-m-d H:i:s");
        }
    }

    public static function base64_urlSafeEncode($data)
    {
        $find = array('+', '/');
        $replace = array('-', '_');
        return str_replace($find, $replace, base64_encode($data));
    }

    public static function getPrivateLink ($url, $format = '')
    {
        $file = urldecode($url);
        if($format){
            if(in_array($format, ['big', 'middle', 'small'])){
                $file .= '-' .$format;
                $url = Yii::$app->params['qiNiuUrl'] . "/{$file}?e=" . ((new DateTime('now', new DateTimeZone('UTC')))->getTimestamp() + 3600);
            }else{
                $file .= '?' .$format;
                $url = Yii::$app->params['qiNiuUrl'] . "/{$file}&e=" . ((new DateTime('now', new DateTimeZone('UTC')))->getTimestamp() + 3600);
            }
        }else{
            $url = Yii::$app->params['qiNiuUrl'] . "/{$file}?e=" . ((new DateTime('now', new DateTimeZone('UTC')))->getTimestamp() + 3600);
        }

        $sha1Base64 = Tools::base64_urlSafeEncode(hash_hmac('sha1', $url, Yii::$app->params['qiNiuSk'], true));
        $token = Yii::$app->params['qiNiuAk'] . ':' . $sha1Base64;
        $url .= '&token='.$token;
        return $url;
    }

    /**
     * 判断是否是图片后缀
     * @param $ext
     *
     * @return bool
     */
    public static function isImg($ext)
    {
        return in_array(strtolower($ext), ['.jpg', '.png', '.gif', '.bmp']);
    }

    /**
     * 判断是否是Email
     * @param $value
     *
     * @return bool
     */
    public static function isEmail ($value)
    {
        $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
        return (boolean) preg_match($pattern, $value);
    }
} 