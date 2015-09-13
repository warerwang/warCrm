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
use app\models\Comment;

class CommentController extends RestController
{
    public function actionIndex ($rid)
    {
        return Comment::findAll(['relationId' => $rid]);
    }

    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $comment = new Comment();
        $comment->ownerId = Yii::$app->user->id;
        $comment->did = Yii::$app->user->identity->did;
//        $comment->relationId = Yii::$app->user->identity->did;
        $comment->setScenario(Comment::SCENARIO_CREATE);
        $comment->load($data, '');
        $comment->save();
        return $comment;
    }

    public function actionDelete ()
    {

    }

//    public function actionView ()
//    {
//
//    }
}