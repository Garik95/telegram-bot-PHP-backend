<?php

namespace app\controllers;

use Yii;
use app\models\SpProduct;
use app\models\SpPrice;
use app\models\SpProductSearch;
use app\models\SpPriceSearch;
use app\models\FileUpload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for SpProduct model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SpProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SpProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=NULL)
    {
        $model = new SpProduct();
        $price = new SpPrice();
        $img = new FileUpload();
        // test(Yii::$app->request->post()); die;
        if ($model->load(Yii::$app->request->post()) && $price->load(Yii::$app->request->post()) /*&& $img->load(Yii::$app->request->post())*/) {
            $img->imageFile = UploadedFile::getInstance($img, 'imageFile');
            $img->upload();
            // die();
            $model->sp_category_id=$id;
            $model->save();
            $price->product_id = $model->product_id;
            $price->save();
            // test($model); die;
            return $this->redirect(['/categories', 'id' => $id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'price' => $price,
                'id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing SpProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $price = SpPrice::find()->where(['product_id'=>$id])->one();
        // $img = new FileUpload();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'price'=>$price,
                'id'=>$id,
            ]);
        }
    }

    /**
     * Deletes an existing SpProduct model.
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
     * Finds the SpProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
