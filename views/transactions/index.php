<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SpTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Корзинка');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-transactions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <? Html::a(Yii::t('app', 'Create Sp Transactions'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'transaction_id',
            [
                'attribute'=>'transaction_id',
                // 'value'=>'user.first_name',
                'format' => 'html',
                'value'=>function ($data) {
if($data->userbyclientid){                    
if ($data->userbyclientid->first_name)
                    return Html::a($data->userbyclientid->first_name, ['users/view','id'=>$data->userbyclientid->id]);
                    else
                    return Html::a($data->userbyid->first_name, ['users/view','id'=>$data->userbyid->id]);
                }
},
            ],
'client_id',
		[
                'attribute'=>'product_id',
                'value'=>'product.product_name',
            ],
            'price_id',
            'v_date',
            'quantity',
            [
                'attribute'=>'state_id',
                'value'=>'status.name_state',
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php
    // You only need add this,
    $this->registerJs('
        var gridview_id = ""; // specific gridview
        var columns = [2,3]; // index column that will grouping, start 1
 
        var column_data = [];
            column_start = [];
            rowspan = [];
 
        for (var i = 0; i < columns.length; i++) {
            column = columns[i];
            column_data[column] = "";
            column_start[column] = null;
            rowspan[column] = 1;
        }
 
        var row = 1;
        $(gridview_id+" table > tbody  > tr").each(function() {
            var col = 1;
            $(this).find("td").each(function(){
                for (var i = 0; i < columns.length; i++) {
                    if(col==columns[i]){
                        if(column_data[columns[i]] == $(this).html()){
                            $(this).remove();
                            rowspan[columns[i]]++;
                            $(column_start[columns[i]]).attr("rowspan",rowspan[columns[i]]);
                        }
                        else{
                            column_data[columns[i]] = $(this).html();
                            rowspan[columns[i]] = 1;
                            column_start[columns[i]] = $(this);
                        }
                    }
                }
                col++;
            })
            row++;
        });
    ');
    ?>
