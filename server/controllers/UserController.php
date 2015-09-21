<?php

namespace app\controllers;

use app\components\RestController;
use app\components\Tools;
use app\exceptions\UserException;
use app\models\Domain;
use app\models\Project;
use app\models\Task;
use app\models\User;
use DateTimeZone;
use Yii;

use yii\base\InvalidValueException;
use yii\db\Exception;
use yii\filters\ContentNegotiator;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use DateTime;

/**
 * Swagger Annotations
 * @SWG\Resource(
 *      resourcePath="/user",
 *      basePath="/",
 *      description="user api"
 * )
 * @SWG\Model(id="User", description="用户模型")(
 * @SWG\Property(name="id",type="string"),
 * @SWG\Property(name="email",type="string"),
 * @SWG\Property(name="group_id",type="string"),
 * @SWG\Property(name="nickname",type="string"),
 * @SWG\Property(name="access_token",type="string"),
 * @SWG\Property(name="create_time",type="string"),
 * @SWG\Property(name="last_activity",type="string"),
 * )
 * @SWG\Model(id="AccessToken", description="登陆凭证")(
 * @SWG\Property(name="id",type="string"),
 * @SWG\Property(name="nickname",type="string"),
 * @SWG\Property(name="access_token",type="string"),
 * @SWG\Property(name="expire_time",type="string"),
 * )
 */
class UserController extends RestController
{
    public $safeActions = ['view', 'create', 'access-token'];

    /**
     * @param \app\models\User $user
     *
     * @throws \app\exceptions\UserException
     */
    public function checkAccess ($user)
    {
        if (empty($user)) {
            throw new UserException(UserException::USER_IS_NOT_EXIST, UserException::USER_IS_NOT_EXIST_CODE);
        }
    }

    public function actionIndex ($did, $status = 1)
    {
        //status 返回所有的
        if ($status == 0) {
            return User::find()->where(['did' => $did])->all();
            //返回对应状态的
        } else {
            return User::find()->where(['did' => $did, 'status' => $status])->all();
        }
    }

    /**
     * @SWG\Api(
     *   path="/user/{id}",
     *   description="用户信息相关接口",
     *   @SWG\Operation(
     *      method="GET",
     *      type="User",
     *      nickname="view",
     *      notes="查询用户信息",
     *      @SWG\Parameter(
     *          name="id",
     *          paramType="path",
     *          required=true,
     *          type="string",
     *          description="用户id"
     *      ),
     *   ),
     *   @SWG\Operation(
     *      method="PUT",
     *      type="User",
     *      nickname="update",
     *      notes="更新用户信息",
     *      @SWG\Parameter(
     *          name="id",
     *          paramType="path",
     *          required=true,
     *          type="string",
     *          description="用户id或者email"
     *      ),
     *      @SWG\Parameter(
     *          name="nickname",
     *          paramType="form",
     *          required=false,
     *          type="string",
     *          description="用户昵称"
     *      ),
     *   ),
     * )
     */
    public function actionView ($id, $status = 1)
    {
        $user = $this->findModel($id);
        $this->checkAccess($user);
        if (!empty($status) && $user->status != $status) {
            throw new NotFoundHttpException("没找到用户");
        }

        return $user;
    }

    public function actionUpdate ($id)
    {
        $request = Yii::$app->request;
        $user    = $this->findModel($id);
        $this->checkAccess($user);
        $user->setScenario(User::SCENARIO_EDIT);
        $data = json_decode($request->rawBody, true);
        $user->load($data, '');
        if (!Yii::$app->user->identity->isAdmin && $id != Yii::$app->user->identity->id) {
            throw new ForbiddenHttpException("权限不足.");
        }
        if (Yii::$app->user->identity->isAdmin) {
            isset($data['status']) && $user->status = $data['status'];
            isset($data['isAdmin']) && $user->isAdmin = $data['isAdmin'];
        }
        if ($user->save()) {
            return $user;
        } else {
            Yii::$app->response->statusCode = 500;

            return $user->getFirstErrors();
        }
    }

    /**
     * @SWG\Api(
     *   path="/user",
     *   description="用户信息相关接口",
     *   @SWG\Operation(
     *      method="POST",
     *      type="User",
     *      nickname="create",
     *      notes="注册用户",
     *      @SWG\Parameter(
     *          name="email",
     *          paramType="form",
     *          required=true,
     *          type="string",
     *          description="用户email"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          paramType="form",
     *          required=true,
     *          type="string",
     *          description="用户密码"
     *      ),
     *      @SWG\Parameter(
     *          name="nickname",
     *          paramType="form",
     *          required=false,
     *          type="string",
     *          description="用户昵称"
     *      ),
     *   ),
     * )
     */


    public function actionCreate ()
    {
        $request = Yii::$app->request;
        $data    = json_decode($request->rawBody, true);
        $user    = new User();
        $user->setScenario(User::SCENARIO_CREATE);
        $user->load($data, '');
        $user->did = $request->get('did');
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
            $user->status  = 1;
            $user->isAdmin = $data['isAdmin'];
        }
        if ($user->save()) {
            return $user;
        } else {
            Yii::$app->response->statusCode = 500;

            return $user->getFirstErrors();
        }
    }

    /**
     * @SWG\Api(
     *   path="/user/access-token",
     *   description="Access-token相关接口",
     *   @SWG\Operation(
     *      method="GET",
     *      type="User",
     *      nickname="create",
     *      notes="用户登陆",
     *      @SWG\Parameter(
     *          name="email",
     *          paramType="query",
     *          required=true,
     *          type="string",
     *          description="用户email"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          paramType="query",
     *          required=true,
     *          type="string",
     *          description="用户密码"
     *      ),
     *   ),
     * )
     */
    public function actionAccessToken ($email, $password)
    {
        /** @var User $user */
        $user = User::findOne(['email' => $email]);
        $this->checkAccess($user);
        if (!$user->validatePassword($password)) {
            throw new UserException(UserException::PASSWORD_IS_INVALID, UserException::PASSWORD_IS_INVALID_CODE);
        }

        return [
            'id'          => $user->id,
            'name'        => $user->name,
            'accessToken' => $user->accessToken,
            'expireTime'  => date('Y-m-d H:i:s', time() + User::EXPIRE_TIME)
        ];
    }

    /**
     * @SWG\Api(
     *   path="/user/current",
     *   description="当前用户相关接口",
     *   @SWG\Operation(
     *      method="GET",
     *      type="User",
     *      nickname="current",
     *      notes="用户登陆",
     *   ),
     * )
     */
    public function actionCurrent ()
    {
        return Yii::$app->user->identity;
    }

    public function actionInviteUser ()
    {
        $rawBody     = Yii::$app->request->rawBody;
        $rawBodyData = json_decode($rawBody, true);
        if (empty($rawBodyData) || !isset($rawBodyData['emails']) || !is_array($rawBodyData['emails'])) {
            throw new InvalidValueException("缺少参数");
        }
        $emails = $rawBodyData['emails'];
        $emails = array_filter($emails, function ($item) {
            if (empty($item)) {
                return false;
            } elseif (!Tools::isEmail($item)) {
                return false;
            } else {
                return true;
            }
        });
        if (empty($emails)) {
            throw new InvalidValueException("缺少参数");
        }
        /** @var Domain $domain */
        $domain      = Domain::findOne(Yii::$app->user->identity->did);
        $subject     = Yii::$app->user->identity->name . "邀请你加入" . $domain->name;
        $expiredTime = Tools::getDateTime(true) + 7 * 24 * 3600;
        foreach ($emails as $email) {
            User::createInActiveUser($domain->id, $email);
            $code   = md5($expiredTime . Yii::$app->id . $email . $domain->id);
            $params = [
                'senderName' => Yii::$app->user->identity->name,
                'teamName'   => $domain->name,
                'link'       => Url::to([
                    '/site/active-account',
                    'did'   => $domain->id,
                    'email' => $email,
                    'c'     => $code,
                    'e'     => $expiredTime
                ], true)
            ];
            Yii::$app->mailer->sendMail($email, $subject, 'invite-user', $params);
        }
    }

    public function actionUpdatePassword ($oldPassword, $newPassword)
    {
        /** @var User $current */
        $current = Yii::$app->user->identity;
        if (!$current->validatePassword($oldPassword)) {
            throw new ForbiddenHttpException("密码不正确");
        }

        $current->password = $newPassword;
        $current->setScenario(User::SCENARIO_EDIT_PASSWORD);
        if (!$current->save()) {
            throw new Exception($current->getFirstErrorContent());
        } else {
            return $current;
        }
    }

    public function actionUpdateAvatar ($avatar)
    {
        /** @var User $current */
        $current = Yii::$app->user->identity;
        $current->setScenario(User::SCENARIO_EDIT_AVATAR);
        $current->avatar = $avatar;
        if (!$current->save()) {
            throw new Exception($current->getFirstErrorContent());
        } else {
            return $current;
        }
    }

    public function actionGetResetPasswordCode ($email)
    {
    }

    public function actionUpdatePasswordByResetCode ($email, $code, $password)
    {
    }

    public function actionDelete ($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);
        if (Yii::$app->user->identity->isAdmin) {
            $model->delete();

            return true;
        } else {
            throw new ForbiddenHttpException("权限不足.");
        }
    }

    public function actionFileToken ($key = null)
    {
        $timeStamp = (new DateTime('now', new DateTimeZone('UTC')))->getTimestamp() + 3600;
        if ($key) {
            $data = [
                'scope'    => Yii::$app->params['scope'] . ':' . $key,
                'deadline' => $timeStamp,
            ];
            $json = json_encode($data);
        } else {
            $json = '{"scope":"' . Yii::$app->params['scope'] . '","deadline":' . $timeStamp . '}';
        }
        $jsonBase64 = Tools::base64_urlSafeEncode($json);
        $sha1       = Tools::base64_urlSafeEncode(hash_hmac('sha1', $jsonBase64, Yii::$app->params['qiNiuSk'], true));

        return Yii::$app->params['qiNiuAk'] . ':' . $sha1 . ':' . $jsonBase64;
    }
    //
    //    public function actionImageUrl ($url)
    //    {
    //        $file = urldecode($url);
    //        $url = Yii::$app->params['qiNiuUrl'] . "/{$file}?e=" . ((new DateTime('now', new DateTimeZone('UTC')))->getTimestamp() + 3600);
    //        $sha1Base64 = Tools::base64_urlSafeEncode(hash_hmac('sha1', $url, Yii::$app->params['qiNiuSk'], true));
    //        $token = Yii::$app->params['qiNiuAk'] . ':' . $sha1Base64;
    //        $url .= '&token='.$token;
    //        echo $url;
    //    }

    /**
     * @param $idOrEmail
     *
     * @return User
     */
    private function findModel ($idOrEmail)
    {
        if (strpos($idOrEmail, '@') === false) {
            return User::findOne($idOrEmail);
        } else {
            return User::findOne(['email' => $idOrEmail]);
        }
    }

    public function actionDashboard ()
    {
        $dashBoardData = [];
        $tasks = Task::find()->where([
            'ownerId' => Yii::$app->user->id,
            'status'  => [
                Task::STATUS_NEW,
                Task::STATUS_FINISHING,
                Task::STATUS_FINISHED,
                Task::STATUS_REJECTED
            ]
        ])->with(['project', 'sprint'])->all();

        $dashBoardData['tasks'] = array_map(function($task){
            /** @var Task $task */
            return $task->toArray([], ['project', 'sprint']);
        }, $tasks);
        $projects = Project::find()->where("did = '".Yii::$app->user->identity->did."' and status in (1,3) and members like '%\"".Yii::$app->user->id."\"%'")->all();
        $dashBoardData['projects'] = Project::expandFields($projects, 'currentSprint');
        return $dashBoardData;
    }
}
