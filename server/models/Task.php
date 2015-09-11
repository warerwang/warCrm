<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午10:06
 */

namespace app\models;


use app\models\base\TasksBase;
class Task extends TasksBase
{
    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "pid",
                "sid",
                "title",
                "content",
                "ownerId",
                "followers"
            ],
            self::SCENARIO_EDIT   => [
                "pid",
                "sid",
                "title",
                "content",
                "ownerId",
                "followers"
            ],
        ];
    }
}