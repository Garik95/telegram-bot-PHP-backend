<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SpTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sp Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-transactions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sp Transactions'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'transaction_id',
            [
                'attribute'=>'transaction_id',
                'value'=>'user.first_name',
            ],
            'client_id',
            'product_id',
            [
                'attribute'=>'product_id',
                'value'=>'product.product_name',
            ],
            'price_id',
            'v_date',
            // 'quantity',
            // 'state_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

