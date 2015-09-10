<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-8
 * Time: 下午10:49
 */

namespace app\controllers;

use yii;
use app\components\RestController;
use app\models\Project;

//todo 权限没有判断
class ProjectController extends RestController
{
    public function actionIndex ($did = null)
    {
        $did = Yii::$app->user->identity->did;
        if($did){
            return Project::findAll(['did' => $did]);
        }else{
            $uid = Yii::$app->user->identity->id;
            return Project::findAll("members like '%$uid%'");
        }
    }

    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $project   = new Project();
        $project->setScenario(Project::SCENARIO_CREATE);
        $project->load($data, '');
        $project->did       = Yii::$app->user->identity->did;
        $project->ownerId   = Yii::$app->user->identity->id;
        if ($project->save()) {
            return $project;
        } else {
            Yii::$app->response->statusCode = 500;
            return $project->getFirstErrors();
        }
    }

    public function actionView ($id)
    {
        return Project::findOne($id);
    }

    public function actionUpdate ($id)
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        /** @var Project $project */
        $project = Project::findOne($id);
        $project->setScenario(Project::SCENARIO_EDIT);
        $project->load($data, '');
        if ($project->save()) {
            return $project;
        } else {
            Yii::$app->response->statusCode = 500;

            return $project->getFirstErrors();
        }
    }

    public function actionDelete ($id)
    {
        return Project::deleteAll(['id' => $id]);
    }
}