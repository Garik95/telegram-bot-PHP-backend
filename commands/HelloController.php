<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Dispatch;
use app\models\SpUsers;
use linslin\yii2\curl;
use yii\helpers\Json;
use yii\web\Application;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    /*public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }*/

	public function actionIndex($id,$msg)
    {
			//ini_set('max_execution_time', 1);
			$curl = new curl\Curl();
			$usrs = SpUsers::find()->where(['<=','id',1])->all();
			//print_r(json_decode('"'.$msg.'"')); die;
			$file_id = "https://somonitrading.com/tg/logo.png";
			//for($i=1;$i<=5;$i++)
			foreach($usrs as $usr)
			{
				$response = $curl->setGetParams([
					'chat_id' => $usr->userid,
					'photo' => $file_id
				])->get('https://api.telegram.org/bot426046945:AAGKx_kmBbLzpGfB8xdqoz3CIi1-Z2yBuqE/sendPhoto');

				$response = $curl->setGetParams([
					'chat_id' => $usr->userid,
					'text' => json_decode('"'.$msg.'"'),
				])->get('https://api.telegram.org/bot426046945:AAGKx_kmBbLzpGfB8xdqoz3CIi1-Z2yBuqE/sendMessage');
			}
			$model = Dispatch::find()->where(['id'=>$id])->one();
			$model->status = 1;
			$model->save();
    }
}
