<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SpProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Продукты');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Добавить'), ['value' => Url::to(['/product/create','id'=>$model->id]),'class' =>'btn btn-success','id'=>'modalButton']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'product_id',
            'product_name',
            // 'product_Description:ntext',
            'Product_calorie',
            // 'product_Photo:ntext',
            'price.Price',
            // 'product_Video:ntext',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Url::to(['/product/view','id'=>$model->product_id]); 
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Url::to(['/product/update','id'=>$model->product_id]); 
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Url::to(['/product/delete','id'=>$model->product_id]);
                        return $url;
                    }
                }

            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php
            Modal::begin([
            // 'header'=> '<h4>Search</h4>',  
            'id' => 'modal',
            'size' => 'modal-lg',
            ]);

            echo "<div id='modalContent'></div>";

            Modal::end();
       ?>
<?php
$this->registerJs("
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        });
    ");
?>