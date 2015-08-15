<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/3/3
 * Time: 上午1:29
 */

namespace app\components;


class Tools
{

    /**
     * @param \yii\base\Model $model
     */
    public static function getFirstError ($model)
    {
        foreach ($model->getErrors() as $error) {
            return $error[0];
        }
    }

    public static function getDateTime()
    {
        $dateTime = new \DateTime();
        return $dateTime->format("Y-m-d H:i:s");
    }
} 