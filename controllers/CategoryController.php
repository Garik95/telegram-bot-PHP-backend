<?php

namespace app\controllers;

use Yii;
use app\models\SpCategory;
use app\models\SpCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * CategoryController implements the CRUD actions for SpCategory model.
 */
class CategoryController extends Controller
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
					'actions' => ['index','create'],
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
     * Lists all SpCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       /* $connection = Yii::$app->getDb();
$command = $connection->createCommand("SELECT id,(select name from `sp_category` s where s.id=c.parent_id) as parent,name,indx  FROM `sp_category` c");
$result = $command->queryAll();*/
        //$q = SpCategory::findBySql("SELECT id,(select name from `sp_category` s where s.id=c.parent_id) as parent,name,indx  FROM `sp_category` c")->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'q'=>$q,
        ]);
    }

    /**
     * Displays a single SpCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actions()
{
    $modelClass = 'namespace\ModelName';

    return [
        'moveNode' => [
            'class' => 'voskobovich\tree\manager\actions\MoveNodeAction',
            'modelClass' => $modelClass,
        ],
        'deleteNode' => [
            'class' => 'voskobovich\tree\manager\actions\DeleteNodeAction',
            'modelClass' => $modelClass,
        ],
        'updateNode' => [
            'class' => 'voskobovich\tree\manager\actions\UpdateNodeAction',
            'modelClass' => $modelClass,
        ],
        'createNode' => [
            'class' => 'voskobovich\tree\manager\actions\CreateNodeAction',
            'modelClass' => $modelClass,
        ],
    ];
}

    /**
     * Creates a new SpCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SpCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SpCategory model.
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
     * Finds the SpCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
