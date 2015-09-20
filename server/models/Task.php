<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午10:06
 */

namespace app\models;


use app\components\Tools;
use app\models\base\TasksBase;

class Task extends TasksBase
{
    CONST STATUS_NEW = 1;
    CONST STATUS_FINISHING = 2;
    CONST STATUS_FINISHED = 3;
    CONST STATUS_REJECTED = 4;
    CONST STATUS_CLOSED = 5;
    CONST STATUS_PAUSED = 6;

    /** status
     * {id:1,name:'新建'},
     * {id:2,name:'解决中'},
     * {id:3,name:'已解决'},
     * {id:4,name:'已拒接'},
     * {id:5,name:'已关闭'},
     * {id:6,name:'已停止'},
     */
    public function rules ()
    {
        $rules = parent::rules();
        $rules[] = [
            'status',
            'in',
            'range' => [
                self::STATUS_NEW,
                self::STATUS_FINISHING,
                self::STATUS_FINISHED,
                self::STATUS_REJECTED,
                self::STATUS_CLOSED,
                self::STATUS_PAUSED
            ]
        ];
        return $rules;
    }

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
                "status",
                "content",
                "ownerId",
                "followers"
            ],
        ];
    }

    public function extraFields ()
    {
        return [
            'project',
            'sprint'
        ];
    }

    public function beforeValidate ()
    {
        if (parent::beforeValidate()) {
            $this->lastModify = Tools::getDateTime();

            return true;
        }

        return false;
    }

    public function getProject ()
    {
        return $this->hasOne(Project::className(), ['id' => 'pid']);
    }

    public function getSprint ()
    {
        return $this->hasOne(Sprint::className(), ['id' => 'sid']);
    }

    public function afterSave ($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //更新project
        //更新sprint
        Project::updateAll(['lastModify' => Tools::getDateTime()], ['id' => $this->pid]);
        if($this->sid){
            /** @var Sprint $sprint */
            $sprint = Sprint::findOne($this->sid);
            $updateAttrs = [];
            if(isset($changedAttributes['status'])){
                if($this->status == self::STATUS_PAUSED) {
                    $updateAttrs['pauseTask'] = ++$sprint->pauseTask;
                }elseif($this->status == self::STATUS_CLOSED){
                    $updateAttrs['closeTask'] = ++$sprint->closeTask;
                }

                if($this->oldAttributes['status'] == Task::STATUS_PAUSED){
                    $updateAttrs['pauseTask'] = --$sprint->pauseTask;
                }elseif($this->oldAttributes['status'] == Task::STATUS_CLOSED){
                    $updateAttrs['closeTask'] = --$sprint->closeTask;
                }
            }
            if($updateAttrs){
                Sprint::updateAll($updateAttrs, ['id' => $this->sid]);
            }
        }
    }

}