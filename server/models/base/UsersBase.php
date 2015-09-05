<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $title
 * @property string $phone
 * @property string $avatar
 * @property string $description
 * @property string $password
 * @property string $salt
 * @property string $did
 * @property integer $isAdmin
 * @property string $createTime
 * @property string $lastActivity
 * @property string $accessToken
 * @property integer $status
 * @property integer $loginStatus
 */
class UsersBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email', 'password', 'salt', 'did', 'accessToken'], 'required'],
            [['isAdmin', 'status', 'loginStatus'], 'integer'],
            [['createTime', 'lastActivity'], 'safe'],
            [['id', 'name', 'did'], 'string', 'max' => 20],
            [['email', 'avatar', 'description'], 'string', 'max' => 256],
            [['title'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 15],
            [['password', 'accessToken'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 6],
            [['id'], 'unique'],
            ['email', 'unique', 'targetAttribute' => ['email', 'did']],
            [['accessToken'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'email' => '邮箱',
            'name' => '姓名',
            'title' => '职务',
            'phone' => '手机',
            'avatar' => '头像',
            'description' => '自我描述',
            'password' => '密码',
            'salt' => 'Salt',
            'did' => 'Did',
            'isAdmin' => '管理员',
            'createTime' => '加入事件',
            'lastActivity' => '最后活跃事件',
            'accessToken' => 'Access-Token',
            'status' => '激活',
            'loginStatus' => '登录状态',
        ];
    }
}
