<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-8
 * Time: 下午10:48
 */

namespace app\models;


use app\components\Tools;
use app\models\base\ProjectsBase;

class Project extends ProjectsBase
{
    public function extraFields ()
    {
        return [
            'taskCount' => function(){
                return Task::find()->where(['pid' =>$this->id])->count();
            },
            'sprintCount' => function(){
                return Sprint::find()->where(['pid' =>$this->id])->count();
            }

        ];
    }

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

    public function beforeValidate ()
    {
        if(parent::beforeValidate()){
            $this->lastModify = Tools::getDateTime();
            return true;
        }
        return false;
    }
}