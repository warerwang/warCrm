<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property string $id
 * @property string $cid
 * @property string $sender
 * @property string $content
 * @property string $createTime
 * @property string $extraData
 * @property integer $did
 */
class MessagesBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cid', 'sender', 'content', 'extraData', 'did'], 'required'],
            [['content', 'extraData'], 'string'],
            [['createTime'], 'safe'],
            [['did'], 'integer'],
            [['id', 'sender'], 'string', 'max' => 20],
            [['cid'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'sender' => 'Sender',
            'content' => 'Content',
            'createTime' => 'Create Time',
            'extraData' => 'Extra Data',
            'did' => 'Did',
        ];
    }
}
