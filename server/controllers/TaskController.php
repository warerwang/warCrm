<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-10
 * Time: 下午10:03
 */

namespace app\controllers;

use yii;
use app\components\RestController;
use app\models\Task;
use yii\data\ActiveDataProvider;

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
        /**
        {id:1,name:'新建'},
        {id:2,name:'解决中'},
        {id:3,name:'已解决'},
        {id:4,name:'已拒接'},
        {id:5,name:'已关闭'},
         */
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
        if ($task->save()) {
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
        if ($task->save()) {
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