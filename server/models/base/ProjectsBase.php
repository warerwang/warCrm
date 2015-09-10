<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property string $id
 * @property string $name
 * @property resource $content
 * @property string $ownerId
 * @property string $members
 * @property integer $status
 * @property integer $type
 * @property string $did
 * @property string $createTime
 * @property string $lastModify
 */
class ProjectsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'content', 'ownerId', 'members', 'status', 'type', 'did'], 'required'],
            [['content'], 'string'],
            [['status', 'type'], 'integer'],
            [['createTime', 'lastModify'], 'safe'],
            [['id', 'name', 'ownerId', 'did'], 'string', 'max' => 20],
            [['members'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'ownerId' => 'Owner ID',
            'members' => 'Members',
            'status' => 'Status',
            'type' => 'Type',
            'did' => 'Did',
            'createTime' => 'Create Time',
            'lastModify' => 'Last Modify',
        ];
    }
}
