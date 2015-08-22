<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property string $id
 * @property integer $type
 * @property string $uid
 * @property string $lastMessage
 * @property string $lastSenderUid
 * @property integer $unReadCount
 * @property string $createTime
 * @property string $lastActivity
 */
class ChatsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'uid'], 'required'],
            [['type', 'unReadCount'], 'integer'],
            [['createTime', 'lastActivity'], 'safe'],
            [['id', 'uid', 'lastMessage', 'lastSenderUid'], 'string', 'max' => 20]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'uid' => 'Uid',
            'lastMessage' => 'Last Message',
            'lastSenderUid' => 'Last Sender Uid',
            'unReadCount' => 'Un Read Count',
            'createTime' => 'Create Time',
            'lastActivity' => 'Last Activity',
        ];
    }
}
