<?php

/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-20
 * Time: 下午7:09
 */
namespace app\behaviors;
use yii;
use yii\base\Behavior;
class ProjectListExtendBehavior extends Behavior
{
    public $currentSprint;
    // 行为的一个方法
    public function getCurrentSprint()
    {
        return 'Method in MyBehavior is called.';
    }
}