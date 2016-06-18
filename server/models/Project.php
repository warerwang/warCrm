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
use yii\base\Exception;
use yii\db\Query;

class Project extends ProjectsBase
{
    public $taskCount;
    public $sprintCount;
    public $currentSprint;

    const STATUS_NORMAL = 1;
    const STATUS_PAUSED = 2;
    const STATUS_FINISHED = 3;

    public function extraFields ()
    {
        //这些方法不能在list中使用，否则会有性能问题。
        return [
            'taskCount' => function(){
                static $onlyOnce = false;
                if($onlyOnce) throw new Exception("错误的调用");
                $onlyOnce = true;
                return Task::find()->where(['pid' =>$this->id])->count();
            },
            'sprintCount' => function(){
                static $onlyOnce = false;
                if($onlyOnce) throw new Exception("错误的调用");
                $onlyOnce = true;
                return Sprint::find()->where(['pid' =>$this->id])->count();
            },
            //当前里程碑是指，还没有过期，或者即将开始的一个里程碑。
            'currentSprint' => function(){
                static $onlyOnce = false;
                if($onlyOnce) throw new Exception("错误的调用");
                $onlyOnce = true;
                return Sprint::find()->where("`pid` = {$this->id} and endTime >'".Tools::getDateTime()."'")->orderBy('id')->one();
            }
        ];
    }
    public function fields(){
        return array_merge(parent::fields(), [
            'taskCount', 'sprintCount', 'currentSprint'
        ]);
    }

    public static function expandFields($projects, $expand)
    {
        $expand = trim($expand);
        if(empty($expand) || empty($project)){
            return $projects;
        }else{
            $expands = explode(',' , $expand);
            $pids = array_map(function($project){
                return $project->id;
            }, $projects);
            $taskCountMap = $sprintCountMap = $currentSprintMap = [];
            if(in_array('taskCount', $expands)){
                //select count(1) as count,pid from sprints  where pid in ('1') group by pid
                $tasks = (new Query())->from(Task::tableName())->select(['count(1) as count', 'pid'])->where(['pid' => $pids])->groupBy(['pid'])->all();
                foreach($tasks as $task){
                    $taskCountMap[$task['pid']] = $task['count'];
                }
            }
            if(in_array('sprintCount', $expands)){
                $sprints = (new Query())->from(Sprint::tableName())->select(['count(1) as count', 'pid'])->where(['pid' => $pids])->groupBy(['pid'])->all();
                foreach($sprints as $sprint){
                    $sprintCountMap[$task['pid']] = $sprint['count'];
                }
            }
            if(in_array('currentSprint', $expands)){
                //return Sprint::find()->where("`pid` = {$this->id} and endTime >'".Tools::getDateTime()."'")->orderBy('id')->one();
                $sprints = (new Query())->from(Sprint::tableName())->where("`pid` in (" . implode(',', $pids) . ") and `endTime` > '".Tools::getDateTime()."'")->groupBy(['pid'])->all();
                foreach($sprints as $sprint){
                    $currentSprintMap[$sprint['pid']] = $sprint;
                }
            }
            /** @var Project $project */
            foreach($projects as $project){
                if(isset($taskCountMap[$project->id])){
                    $project->taskCount = $taskCountMap[$project->id];
                }
                if(isset($sprintCountMap[$project->id])){
                    $project->sprintCount = $sprintCountMap[$project->id];
                }
                if(isset($currentSprintMap[$project->id])){
                    $project->currentSprint = $currentSprintMap[$project->id];
                }
            }
            return $projects;
        }
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