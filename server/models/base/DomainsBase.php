<?php

namespace app\models\base;

use app\components\Model;
use Yii;

/**
 * This is the model class for table "domains".
 *
 * @property integer $id
 * @property string $domain
 * @property string $name
 * @property string $description
 * @property string $log
 * @property integer $status
 */
class DomainsBase extends Model
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
            [['id', 'domain', 'name', 'description', 'log'], 'required'],
            [['id', 'status'], 'integer'],
            [['domain'], 'string', 'max' => 64],
            [['name', 'description', 'log'], 'string', 'max' => 256]
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
            'log' => 'Log',
            'status' => 'Status',
        ];
    }
}
