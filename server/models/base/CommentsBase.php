<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property string $id
 * @property string $ownerId
 * @property string $did
 * @property string $content
 * @property string $createTime
 * @property string $lastModify
 * @property string $relationId
 * @property string $type
 */
class CommentsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ownerId', 'did', 'content', 'relationId', 'type'], 'required'],
            [['content'], 'string'],
            [['createTime', 'lastModify'], 'safe'],
            [['id', 'ownerId', 'did', 'relationId'], 'string', 'max' => 20],
            ['type', 'in', 'range' => ['task', 'article']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ownerId' => 'Owner ID',
            'did' => 'Did',
            'content' => 'Content',
            'createTime' => 'Create Time',
            'lastModify' => 'Last Modify',
            'relationId' => 'Relation ID',
            'type' => 'type',
        ];
    }
}
