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
class StartController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->db->createCommand("set global wait_timeout=2592000")->execute();
        // 加载所有Applications/*/start.php，以便启动所有服务
        foreach(glob(dirname(__DIR__).'/WorkerApp/start*.php') as $start_file)
        {
            require_once $start_file;
        }
        Worker::$stdoutFile = Yii::$app->runtimePath. '/logs/' . date("Y_m_d").'.log';
        Worker::runAll();
    }
}