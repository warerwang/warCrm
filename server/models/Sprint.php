<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午9:48
 */

namespace app\models;


use app\models\base\SprintsBase;

/**
 * Class Sprint
 * @method Sprint static findOne
 * @package app\models
 */
class Sprint extends SprintsBase
{
    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "pid",
                "name",
                "startTime",
                "endTime"
            ],
            self::SCENARIO_EDIT   => [
                "name",
                "startTime",
                "endTime"
            ],
        ];
    }
}