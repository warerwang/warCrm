<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "domains".
 *
 * @property string $id
 * @property string $domain
 * @property string $name
 * @property string $description
 * @property string $logo
 * @property integer $status
 * @property string $createTime
 */
class DomainsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domains';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'domain', 'name', 'description', 'logo'], 'required'],
            [['status'], 'integer'],
            [['createTime'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['domain'], 'string', 'max' => 64],
            [['name', 'description', 'logo'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'name' => 'Name',
            'description' => 'Description',
            'logo' => 'Logo',
            'status' => 'Status',
            'createTime' => 'Create Time',
        ];
    }
}
