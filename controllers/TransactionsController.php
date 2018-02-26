<?php


namespace app\controllers;

use Yii;
use app\models\SpTransactions;
use app\models\SpUsers;
use app\models\SpTransactionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * TransactionsController implements the CRUD actions for SpTransactions model.
 */
class TransactionsController extends Controller
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
					'actions' => ['index','create','deliver'],
					'allow' => true,
					'roles' => ['@'],
				],
			],
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
     * Lists all SpTransactions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpTransactions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionDeliver($id,$type)
    {
        $user = SpUsers::find()->where(['id'=>$id])->one();
        if($type == "cash")
        {
            $model = SpTransactions::find()->where(['or','client_id='.$id,'client_id='.$user->userid])->andWhere(['state_id'=>2])->all();
            foreach ($model as $m) {
                $m->state_id = 4;
                $m->save();
            }
        }elseif ($type == "click") {
            $model = SpTransactions::find()->where(['or','client_id='.$id,'client_id='.$user->userid])->andWhere(['state_id'=>3])->all();
            foreach ($model as $m) {
                $m->state_id = 4;
                $m->save();
            }
        }elseif ($type == "close") {
            $model = SpTransactions::find()->where(['or','client_id='.$id,'client_id='.$user->userid])->andWhere(['state_id'=>4])->all();
            foreach ($model as $m) {
                $m->state_id = 5;
                $m->save();
            }
        }
        return $this->render('/users/view', [
            'model' => SpUsers::findOne($id),
        ]);
    }

    /**
     * Creates a new SpTransactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpTransactions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->transaction_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SpTransactions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->transaction_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SpTransactions model.
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
     * Finds the SpTransactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpTransactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpTransactions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
