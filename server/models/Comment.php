<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午9:48
 */

namespace app\models;


use app\components\Tools;
use app\models\base\CommentsBase;
use yii\db\Exception;

class Comment extends CommentsBase
{
    public function scenarios ()
    {
        return [
            self::SCENARIO_CREATE => [
                "content",
                "relationId",
                "type"
            ]
        ];
    }

    public function afterSave ($insert, $changedAttributes)
    {
        if($insert){
            if($this->type == 'task'){
                $task = Task::findOne($this->relationId);
                if($task){
                    $task->lastModify = Tools::getDateTime();
                    $task->save(false);
                }else{
                    $this->delete();
                    throw new Exception("添加回复时， 没有找到任务单， 任务id: " . $this->relationId);
                }
            }
        }
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