<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午10:03
 */

namespace app\controllers;

use app\components\Tools;
use app\models\Project;
use app\models\Sprint;
use yii;
use app\components\RestController;
use app\models\Task;
use yii\data\ActiveDataProvider;

/**
{id:1,name:'新建'},
{id:2,name:'解决中'},
{id:3,name:'已解决'},
{id:4,name:'已拒接'},
{id:5,name:'已关闭'},
 */
class TaskController extends RestController
{
    public function actionIndex ($pid = null, $sid = null, $status = null, $ownerId = null, $createUid = null)
    {
        $query = Task::find();
        $query->andFilterWhere([
            'pid' => $pid,
            'sid' => $sid,
            'ownerId' => $ownerId,
            'createUserId' => $createUid
        ]);
        if($status > 0){
            $query->andWhere(['status' => $status]);
        }elseif($status < 0){
            $query->andWhere(['NOT', ['status' => abs($status)]]);
        }
        if(empty($query->where)){
            $query->andWhere(['did' => Yii::$app->user->identity->did]);
        }
        $provider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $provider;
    }

    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $task   = new Task();
        $task->setScenario(Task::SCENARIO_CREATE);
        $task->load($data, '');
        $task->did       = Yii::$app->user->identity->did;
        $task->createUid = Yii::$app->user->identity->id;
        /** @var Project $project */
        $project = Project::findOne($task->pid);
        if(empty($project)){
            throw new yii\web\NotFoundHttpException("project");
        }
        if($task->sid){
            /** @var Sprint $sprint */
            $sprint = Sprint::findOne($task->sid);
            if(empty($sprint)){
                throw new yii\web\NotFoundHttpException("sprint");
            }
        }
        if ($task->save()) {
//            $project->updateAttributes(['lastModify' => Tools::getDateTime()]);
//            isset($sprint) && $sprint->updateCounters(['totalTask' => 1]);
            return $task;
        } else {
            Yii::$app->response->statusCode = 500;
            return $task->getFirstErrors();
        }
    }

    public function actionUpdate ($id)
    {
        $request = Yii::$app->request;
        /** @var Task $task */
        $task = Task::findOne($id);
        $task->setScenario(Task::SCENARIO_EDIT);
        $data = json_decode($request->rawBody, true);
        $task->load($data, '');
        /** @var Project $project */
        $project = Project::findOne($task->pid);
        if(empty($project)){
            throw new yii\web\NotFoundHttpException("");
        }
        if($task->sid){
            /** @var Sprint $sprint */
            $sprint = Sprint::findOne($task->sid);
            if(empty($sprint)){
                throw new yii\web\NotFoundHttpException("");
            }
        }
        if ($task->save()) {
//            if(isset($sprint)){
//                if($task->isAttributeChanged('status')){
//                    if($task->status == Task::STATUS_PAUSED){
//                        $sprint->updateCounters(['pauseTask' => 1]);
//                    }elseif($task->status == Task::STATUS_CLOSED){
//                        $sprint->updateCounters(['closeTask' => 1]);
//                    }
//                    if($task->oldAttributes['status'] == Task::STATUS_PAUSED){
//                        $sprint->updateCounters(['pauseTask' => -1]);
//                    }elseif($task->oldAttributes['status'] == Task::STATUS_CLOSED){
//                        $sprint->updateCounters(['closeTask' => -1]);
//                    }
//                }
//            }
            return $task;
        } else {
            Yii::$app->response->statusCode = 500;
            return $task->getFirstErrors();
        }
    }

    public function actionDelete ($id)
    {
        $task = Task::findOne($id);
        return $task->delete();
    }

    public function actionView ($id)
    {
        $task = Task::findOne($id);
        return $task;
    }
}