<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpTransactionState */

$this->title = Yii::t('app', 'Create Sp Transaction State');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Transaction States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-transaction-state-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
