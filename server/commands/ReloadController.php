<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;
use yii;
use yii\console\Controller;
use Workerman\Worker;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ReloadController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->db->createCommand("set wait_timeout=2592000")->execute();
        Worker::runAll();
        Worker::$stdoutFile = Yii::$app->runtimePath. '/logs/' . date("Y_m_d").'.log';
    }
}