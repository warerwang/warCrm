<?php

namespace app\controllers;

use app\models\form\CreateDomainForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\ForbiddenHttpException;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $model = new CreateDomainForm();
        if($request->isPost){
            $model->load($request->post());
            $isValidate = $model->validate();
            if($request->post('submit') == 2 && !empty($model->domain)){
                $this->redirect('http://' . $model->domain . Yii::$app->params['base_client']);
            }elseif($isValidate){
                $this->redirect(['create-domain', 'domain' => $model->domain]);
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    public function actionCreateDomain ($domain)
    {
        $model = new CreateDomainForm();
        $model->setScenario(CreateDomainForm::CREATE_STEP2);

        $model->domain = $domain;
        $request = Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->createDomain()){
                $this->redirect('http://' . $model->domain . Yii::$app->params['base_client']);
            }
        }

        return $this->render('create-domain', ['model' => $model]);
    }

    public function actionTestMail ($email)
    {
        Yii::$app->mailer->sendMail($email, 'test');
    }
}
