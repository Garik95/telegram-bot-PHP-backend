<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpTransactions */

$this->title = Yii::t('app', 'Create Sp Transactions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-transactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
