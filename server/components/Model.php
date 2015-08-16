<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/1/29
 * Time: 上午1:08
 */

namespace app\components;

use yii\db\ActiveRecord;
use yii\db\Query;

class Model extends ActiveRecord
{
    public function beforeValidate ()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                $result   = (new Query())->select('uuid_short() as uuid')->one();
                $this->id = $result['uuid'];
                $this->createTime = (new \DateTime())->format("Y-m-d H:i:s");
            }
            return true;
        }
    }
} 