<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpTransactionState */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sp Transaction State',
]) . $model->state_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Transaction States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->state_id, 'url' => ['view', 'id' => $model->state_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sp-transaction-state-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
