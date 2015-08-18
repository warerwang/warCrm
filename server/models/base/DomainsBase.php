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
            [['id', 'domain', 'name'], 'required'],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 20],
            [['domain'], 'string', 'max' => 64],
            [['name', 'description', 'logo'], 'string', 'max' => 256],
            [['id'], 'unique'],
            [['domain'], 'unique'],
            ['domain', 'match', 'pattern' => '/[0-9a-zA-z\-]{5,64}/'],
            [['name', 'description', 'logo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'domain' => '域名',
            'name' => '团队名',
            'description' => '简介',
            'logo' => 'Logo',
            'status' => '状态',
            'createTime' => '创建时间',
        ];
    }
}
