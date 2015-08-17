<?php

namespace app\controllers;

use app\components\RestController;
use app\exceptions\UserException;
use app\models\User;
use Yii;

use yii\filters\ContentNegotiator;
use yii\web\Response;

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

    public function actionIndex ()
    {
        return User::find()->where(['did' => 1])->all();
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
    public function actionView ($id)
    {
        $user = $this->findModel($id);
        $this->checkAccess($user);

        return $user;
    }

    public function actionUpdate ($id)
    {
        $request  = Yii::$app->request;
        $user     = $this->findModel($id);
        $this->checkAccess($user);
        $data = json_decode($request->rawBody, true);
        $user->load($data, '');
        $user->save();
        return $user;
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
        $request  = Yii::$app->request;
        $email    = $request->post('email');
        $password = $request->post('password');
        $nickname = $request->post('nickname');

        return User::create($email, $password, User::GROUP_USER, $nickname);
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
        $user     = User::findOne(['email' => $email]);
        $this->checkAccess($user);
        if (!$user->validatePassword($password)) {
            throw new UserException(UserException::PASSWORD_IS_INVALID, UserException::PASSWORD_IS_INVALID_CODE);
        }

        return [
	        'id'           => $user->id,
	        'nickName'     => $user->nickName,
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

    public function actionUpdatePassword ($oldpassword, $newpassword)
    {

    }

    public function actionGetResetPasswordCode ($email)
    {

    }

    public function actionUpdatePasswordByResetCode ($email, $code, $password)
    {

    }

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
}
