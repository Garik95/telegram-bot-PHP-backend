<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpProduct */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sp Product',
]) . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sp-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'price'=>$price,
        'id'=>$id,
    ]) ?>

</div>
