<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model app\models\SpUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Клиенты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
// test($model->userid);
/*$status_1 = (new Query)->select('`s`.`product_id`,`s`.`quantity`, (`price_id`*`quantity`) total, p.`product_name`')->from('sp_transactions s')->join('LEFT JOIN','sp_product p','p.product_id = s.product_id')->Where(['state_id'=>1])->andWhere(['or','client_id='.$model->userid,'client_id='.$model->id])->all();*/
$status_2 = (new Query)->select('`s`.`product_id`,`s`.`quantity`, (`price_id`*`quantity`) total, p.`product_name`')->from('sp_transactions s')->join('LEFT JOIN','sp_product p','p.product_id = s.product_id')->Where(['state_id'=>2])->andWhere(['or','client_id='.$model->userid,'client_id='.$model->id])->all();
$status_3 = (new Query)->select('`s`.`product_id`,`s`.`quantity`, (`price_id`*`quantity`) total, p.`product_name`')->from('sp_transactions s')->join('LEFT JOIN','sp_product p','p.product_id = s.product_id')->Where(['state_id'=>3])->andWhere(['or','client_id='.$model->userid,'client_id='.$model->id])->all();
$status_4 = (new Query)->select('`s`.`product_id`,`s`.`quantity`, (`price_id`*`quantity`) total, p.`product_name`,`r`.`id`')->from('sp_transactions s')->join('LEFT JOIN','sp_product p','p.product_id = s.product_id')->join('LEFT JOIN','receipt_id r','r.transaction_id = s.transaction_id')->Where(['state_id'=>4])->andWhere(['or','client_id='.$model->userid,'client_id='.$model->id])->all();
$status_all = (new Query)->select('`s`.`product_id`,`s`.`quantity`, (`price_id`*`quantity`) total, p.`product_name`,`r`.`id`,`s`.`v_date`')->from('sp_transactions s')->join('LEFT JOIN','sp_product p','p.product_id = s.product_id')->join('LEFT JOIN','receipt_id r','r.transaction_id = s.transaction_id')->Where(['state_id'=>'5'])->andWhere(['or','client_id='.$model->userid,'client_id='.$model->id])->orderBy(['v_date'=>SORT_DESC])->all();
//test($status_all);
?>
<div class="sp-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <? Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <table class="table table-striped table-striped">
        <tr>
            <th>ID</th>
            <th>UserId</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Код языка</th>
            <th>Имя пользователья</th>
            <th>Статус</th>
        </tr>
        <tr>
            <td><?= $model->id?></td>
            <td><?= $model->userid?></td>
            <td><?= $model->first_name?></td>
            <td><?= $model->last_name?></td>
            <td><?= $model->language_code?></td>
            <td><?= $model->username?></td>
            <td><?= $model->status?></td>
        </tr>
    </table>
<div class="row">   
    <div class="col-md-3">
        <h1>Оформлено:</h1>
        <?php
        if(!empty($status_2['0']))
        echo Html::a("Доставить",Url::to(['/transactions/deliver','id'=>$model->id,'type'=>'cash']),['class'=>'btn btn-success']); 
        else  echo Html::a("Доставить",Url::to('#'),['class'=>'btn btn-success disabled']);
        ?>
    </div>
    <div class="col-md-3">
        <h1>Оплачено:</h1>
        <?php
        if(!empty($status_3['0']))
        echo Html::a("Доставить",Url::to(['/transactions/deliver','id'=>$model->id,'type'=>'click']),['class'=>'btn btn-success']); 
        else  echo Html::a("Доставить",Url::to('#'),['class'=>'btn btn-success disabled']);
        ?>
    </div>
    <div class="col-md-6">
        <h1>В пути:</h1>
        <?php
        if(!empty($status_4['0']))
        echo Html::a("Закрыть",Url::to(['/transactions/deliver','id'=>$model->id,'type'=>'close']),['class'=>'btn btn-success']); 
        else  echo Html::a("Закрыть",Url::to('#'),['class'=>'btn btn-success disabled']);
        ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <table class="table table-striped table-bordered">
            <?php
                echo "<tr><th>Продукт</th><th>Количество</th><th>Сумма</th></tr>";
                foreach ($status_2 as $st) {
                    echo "<tr><td>".$st['product_name']."</td>";
                    echo "<td>".$st['quantity']."</td>";
                    echo "<td>".$st['total']."</td></tr>";
                }
            ?>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-striped table-bordered">
            <?php
                echo "<tr><th>Продукт</th><th>Количество</th><th>Сумма</th></tr>";
                foreach ($status_3 as $st) {
                    echo "<tr><td>".$st['product_name']."</td>";
                    echo "<td>".$st['quantity']."</td>";
                    echo "<td>".$st['total']."</td></tr>";
                }
            ?>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <?php
                echo "<tr><th>Продукт</th><th>Количество</th><th>Сумма</th><th>Счет</th></tr>";
                foreach ($status_4 as $st) {
                    echo "<tr><td>".$st['product_name']."</td>";
                    echo "<td>".$st['quantity']."</td>";
                    echo "<td>".$st['total']."</td>";
                    echo "<td>".$st['id']."</td></tr>";
                }
            ?>
        </table>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<h1>История</h1>
		<table class="table table-striped table-bordered">
            <?php
                echo "<tr><th>Продукт</th><th>Количество</th><th>Сумма</th><th>Счет</th><th>Дата</th></tr>";
                foreach ($status_all as $st) {
                    echo "<tr><td>".$st['product_name']."</td>";
                    echo "<td>".$st['quantity']."</td>";
                    echo "<td>".$st['total']."</td>";
					echo "<td>".$st['id']."</td>";
                    echo "<td>".$st['v_date']."</td></tr>";
                }
            ?>
        </table>
	</div>
</div>

</div>
