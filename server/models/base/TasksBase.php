<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property string $id
 * @property string $pid
 * @property string $sid
 * @property string $did
 * @property string $title
 * @property string $content
 * @property string $createUid
 * @property string $ownerId
 * @property string $followers
 * @property string $createTime
 * @property string $lastModify
 * @property integer $status
 */
class TasksBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'sid', 'did', 'title', 'content', 'createUid', 'ownerId', 'followers', 'status'], 'required'],
            [['content', 'createTime', 'lastModify'], 'safe'],
            [['followers'], 'string'],
            [['status'], 'integer'],
            [['id', 'pid', 'sid', 'did', 'createUid', 'ownerId'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'sid' => 'Sid',
            'did' => 'Did',
            'title' => 'Title',
            'content' => 'Content',
            'createUid' => 'Create User ID',
            'ownerId' => 'Owner ID',
            'followers' => 'Followers',
            'createTime' => 'Create Time',
            'lastModify' => 'Last Modify',
            'status' => 'Status',
        ];
    }
}
