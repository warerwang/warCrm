<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/23
 * Time: 下午9:56
 */

namespace app\controllers;

use app\models\Group;
use yii;
use app\components\RestController;

class GroupController extends RestController
{
    public function actionIndex ($did)
    {
        return Group::findAll(['did' => $did]);
    }

    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $group   = new Group();
        $group->setScenario(Group::SCENARIO_CREATE);
        $group->load($data, '');
        $group->did       = Yii::$app->user->identity->did;
        $group->createUid = Yii::$app->user->identity->id;
        if ($group->save()) {
            return $group;
        } else {
            Yii::$app->response->statusCode = 500;

            return $group->getFirstErrors();
        }
    }

    public function actionUpdate ($id)
    {
        $request = Yii::$app->request;
        /** @var Group $group */
        $group = Group::findOne($id);
        if (empty($group) || $group->createUid != Yii::$app->user->identity->id) {
            throw new yii\base\Exception('不存在');
        }
        $group->setScenario(Group::SCENARIO_EDIT);
        $data = json_decode($request->rawBody, true);
        $group->load($data, '');
        if ($group->save()) {
            return $group;
        } else {
            Yii::$app->response->statusCode = 500;

            return $group->getFirstErrors();
        }
    }

    public function actionDelete ($id)
    {
        /** @var Group $group */
        $group = Group::findOne($id);
        if (empty($group) || $group->createUid != Yii::$app->user->identity->id) {
            throw new yii\base\Exception('不存在');
        }
        if($group->delete()){
            return true;
        }else{
            Yii::$app->response->statusCode = 500;
            return $group->getFirstErrors();
        }
    }

    public function actionView ($id)
    {
        /** @var Group $group */
        $group = Group::findOne($id);
        if(empty($group)){
            throw new yii\web\NotFoundHttpException('不存在');
        }else{
            return $group;
        }
    }
}