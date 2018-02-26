<?php

namespace app\controllers;

use Yii;
use app\models\Dispatch;
use app\models\SpUsers;
use app\models\DispatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use linslin\yii2\curl;
use yii\filters\AccessControl;

/**
 * DispatchController implements the CRUD actions for Dispatch model.
 */
class DispatchController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			    'access' => [
            'class' => AccessControl::className(),
				'rules' => [
				[
					'actions' => ['index','create','view','update','delete'],
					'allow' => true,
					'roles' => ['@'],
				],                                                                                                                                                  ],
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dispatch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DispatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dispatch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$model->text = json_decode($model->text);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Dispatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dispatch();

        if ($model->load(Yii::$app->request->post()) ) {
			$model->text = json_encode($model->text);
			$model->save();

			exec('nohup /home/admin/web/novatio.uz/public_html/yii hello '.$model->id.' '.$model->text.' > /dev/null 2>&1 &');
			//exec('cd .. && php yii hello '.$model->text.' > /dev/null 2>/dev/null &');
						
			/*$usrs = SpUsers::find()->all();
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
		\Yii::$app->getSession()->setFlash('in progress','Задача выполяется...');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dispatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->text = json_encode($model->text);
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
			$model->text = json_decode($model->text);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dispatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dispatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dispatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dispatch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
