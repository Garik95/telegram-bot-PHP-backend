<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpPrice */

$this->title = Yii::t('app', 'Create Sp Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
