<?php

namespace app\controllers;

use app\components\Tools;
use app\models\Domain;
use app\models\form\ActiveUserForm;
use app\models\form\CreateDomainForm;
use app\models\User;
use Yii;
use yii\base\InvalidValueException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\ForbiddenHttpException;

class SiteController extends Controller
{
    public $navItems = [];
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
        $this->navItems = [
            ['label' => '首页', 'url' => '#page-top', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => '功能', 'url' => '#features', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => '团队', 'url' => '#team', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => '反馈', 'url' => '#testimonials', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => '价格', 'url' => '#pricing', 'linkOptions' => ['class' => 'page-scroll']],
            ['label' => '联系我们', 'url' => '#contact', 'linkOptions' => ['class' => 'page-scroll']],
        ];
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

    public function actionCreateDomain ($domain = null)
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


    public function actionActiveAccount($did, $email, $c, $e)
    {
        if(md5($e . Yii::$app->id . $email . $did) != $c){
            throw new InvalidValueException("无效的链接");
        }
        if(Tools::getDateTime(true) > $e){
            throw new InvalidValueException("链接已经过期！");
        }
        $domainInfo = Domain::findOne($did);
        /** @var ActiveUserForm $model */
        $model = ActiveUserForm::findOne(['did' => $did, 'email' => $email]);
        $model->password = '';
        if(empty($model)){
            throw new InvalidValueException("无效的链接");
        }elseif($model->status == 1){
            throw new InvalidValueException("用户已经处于激活状态,请直接登录");
        }

        $model->setScenario(ActiveUserForm::SCENARIO_CREATE);
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->activeUser()){
                $this->redirect('http://' . $domainInfo->domain . Yii::$app->params['base_client']);
            }else{
                print_r($model->errors);
                die;
            }
        }
        return $this->render('active-account', ['domainInfo' => $domainInfo, 'model' => $model]);
    }

    public function actionTestMail ($email)
    {
        Yii::$app->mailer->sendMail($email,'subject' ,'test');
    }
}
