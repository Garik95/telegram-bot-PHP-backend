<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpTransactions */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sp Transactions',
]) . $model->transaction_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transaction_id, 'url' => ['view', 'id' => $model->transaction_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sp-transactions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
