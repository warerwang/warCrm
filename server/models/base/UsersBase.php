<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $nickName
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
            [['nickName'], 'string', 'max' => 40],
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
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'nickName' => 'Nick Name',
            'phone' => 'Phone',
            'avatar' => 'Avatar',
            'description' => 'Description',
            'password' => 'Password',
            'salt' => 'Salt',
            'did' => 'Did',
            'isAdmin' => 'Is Admin',
            'createTime' => 'Create Time',
            'lastActivity' => 'Last Activity',
            'accessToken' => 'Access Token',
            'status' => 'Status',
            'loginStatus' => 'Login Status',
        ];
    }
}
