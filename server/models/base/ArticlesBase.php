<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property string $id
 * @property string $pid
 * @property string $did
 * @property string $ownerId
 * @property string $title
 * @property string $content
 * @property string $createTime
 * @property string $lastModify
 */
class ArticlesBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'did', 'ownerId', 'title', 'content'], 'required'],
            [['content'], 'string'],
            [['createTime', 'lastModify'], 'safe'],
            [['id', 'pid', 'did', 'ownerId'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 256]
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
            'did' => 'Did',
            'ownerId' => 'Owner ID',
            'title' => 'Title',
            'content' => 'Content',
            'createTime' => 'Create Time',
            'lastModify' => 'Last Modify',
        ];
    }
}
