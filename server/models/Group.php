<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/23
 * Time: 下午9:56
 */

namespace app\models;


use app\models\base\GroupsBase;

class Group extends GroupsBase
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT   = 'edit';

    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "members",
                "name",
                "avatar",
                "description"
            ],
            self::SCENARIO_EDIT   => [
                "members",
                "name",
                "avatar",
                "description"
            ],
        ];
    }
} 