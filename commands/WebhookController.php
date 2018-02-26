<?php
namespace app\commands;

//use Yii;
//use app\models\Dispatch;
//use app\models\SpUsers;
//use app\models\DispatchSearch;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\helpers\Json;
//use linslin\yii2\curl;

class WebhookController extends Controller
{

    public function actionIndex()
    {
        /*$model = new Dispatch();
		$curl = new curl\Curl();

			$usrs = SpUsers::find()->where(['>=','id',2])->all();
			$file_id = "https://somonitrading.com/tg/logo.png";
			foreach($usrs as $usr)
			{
				$response = $curl->setGetParams([
					'chat_id' => $usr->userid,
					'photo' => $file_id
				])->get('https://api.telegram.org/bot426046945:AAGKx_kmBbLzpGfB8xdqoz3CIi1-Z2yBuqE/sendPhoto');

				$response = $curl->setGetParams([
					'chat_id' => $usr->userid,
					'text' => json_decode($model->text)
				])->get('https://api.telegram.org/bot426046945:AAGKx_kmBbLzpGfB8xdqoz3CIi1-Z2yBuqE/sendMessage');
			}*/
    }
}
