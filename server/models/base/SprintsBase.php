<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "sprints".
 *
 * @property string $id
 * @property string $pid
 * @property string $did
 * @property string $name
 * @property string $createTime
 * @property string $startTime
 * @property string $endTime
 */
class SprintsBase extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sprints';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'did', 'name'], 'required'],
            [['createTime', 'startTime', 'endTime'], 'safe'],
            [['id', 'pid', 'did'], 'string', 'max' => 20],
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
            'pid' => 'Pid',
            'did' => 'Did',
            'name' => 'Name',
            'createTime' => 'Create Time',
            'startTime' => 'Start Time',
            'endTime' => 'End Time',
        ];
    }
}
