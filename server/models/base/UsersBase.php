<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $nickName
 * @property string $avatar
 * @property string $description
 * @property string $password
 * @property string $salt
 * @property integer $did
 * @property integer $isAdmin
 * @property string $createTime
 * @property string $lastActivity
 * @property string $accessToken
 * @property integer $status
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
            [['id', 'email', 'firstName', 'lastName', 'nickName', 'description', 'did', 'isAdmin', 'accessToken', 'status'], 'required'],
            [['did', 'isAdmin', 'status'], 'integer'],
            [['createTime', 'lastActivity'], 'safe'],
            [['id', 'firstName', 'lastName'], 'string', 'max' => 20],
            [['email', 'avatar', 'description'], 'string', 'max' => 256],
            [['nickName'], 'string', 'max' => 40],
            [['password', 'accessToken'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 6]
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
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'nickName' => 'Nick Name',
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
        ];
    }
}
