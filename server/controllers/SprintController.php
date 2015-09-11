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
use app\models\Sprint;

class SprintController extends RestController
{
    public function actionIndex ($pid)
    {
        return Sprint::findAll(['pid' => $pid]);
    }

    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $sprint   = new Sprint();
        $sprint->setScenario(Sprint::SCENARIO_CREATE);
        $sprint->load($data, '');
        $sprint->did       = Yii::$app->user->identity->did;
        if ($sprint->save()) {
            return $sprint;
        } else {
            Yii::$app->response->statusCode = 500;
            return $sprint->getFirstErrors();
        }
    }

    public function actionDelete ($id)
    {
        $sprint = Sprint::findOne($id);
        $this->checkAccess($sprint);
        $sprint->delete();
    }

    public function actionView ($id)
    {
        $sprint = Sprint::findOne($id);
        $this->checkAccess($sprint);
        return $sprint;
    }

    public function actionUpdate ($id)
    {
        $sprint = Sprint::findOne($id);
        $this->checkAccess($sprint);
        $sprint->setScenario(Sprint::SCENARIO_EDIT);
        $data = json_decode($sprint->rawBody, true);
        $sprint->load($data, '');
        if ($sprint->save()) {
            return $sprint;
        } else {
            Yii::$app->response->statusCode = 500;
            return $sprint->getFirstErrors();
        }
    }

    public function checkAccess ($model)
    {
        if(empty($model)){
            throw new yii\web\NotFoundHttpException("资源不存在.");
        }
    }
}