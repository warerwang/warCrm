<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property string $id
 * @property string $did
 * @property string $createUid
 * @property string $members
 * @property string $name
 * @property string $description
 * @property string $createTime
 * @property string $lastActivity
 */
class GroupsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'did', 'createUid', 'members', 'name'], 'required'],
            [['createTime', 'lastActivity'], 'safe'],
            [['id', 'did', 'createUid'], 'string', 'max' => 20],
            [['members', 'description'], 'string', 'max' => 256],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'did' => 'Did',
            'createUid' => 'Create Uid',
            'members' => 'Members',
            'name' => 'Name',
            'description' => 'Description',
            'createTime' => 'Create Time',
            'lastActivity' => 'Last Activity',
        ];
    }
}
