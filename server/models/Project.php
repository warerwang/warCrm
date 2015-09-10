<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-8
 * Time: 下午10:48
 */

namespace app\models;


use app\models\base\ProjectsBase;

class Project extends ProjectsBase
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'edit';

    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "name",
                "content",
                "members",
                "type"
            ],
            self::SCENARIO_EDIT   => [
                "name",
                "content",
                "members",
                "type"
            ],
        ];
    }
}