<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpProduct */

$this->title = Yii::t('app', 'Create Sp Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'price' => $price,
        'id' => $id,
    ]) ?>

</div>
