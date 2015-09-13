<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午9:48
 */

namespace app\models;


use app\models\base\CommentsBase;

class Comment extends CommentsBase
{
    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "content",
                "relationId"
            ]
        ];
    }

}