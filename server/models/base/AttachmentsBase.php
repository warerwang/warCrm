<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "attachments".
 *
 * @property string $id
 * @property string $name
 * @property integer $size
 * @property string $key
 * @property string $ext
 * @property string $chatId
 * @property string $ownerId
 * @property string $createTime
 * @property string $did
 */
class AttachmentsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'size', 'key', 'ext', 'chatId', 'ownerId', 'did'], 'required'],
            [['size'], 'integer'],
            [['createTime'], 'safe'],
            [['id', 'ext', 'ownerId', 'did'], 'string', 'max' => 20],
            [['name', 'key'], 'string', 'max' => 256],
            [['chatId'], 'string', 'max' => 40]
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
            'size' => 'Size',
            'key' => 'Key',
            'ext' => 'Ext',
            'chatId' => 'Chat ID',
            'ownerId' => 'Owner ID',
            'createTime' => 'Create Time',
            'did' => 'Did',
        ];
    }
}
