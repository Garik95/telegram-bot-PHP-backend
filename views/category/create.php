<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SpCategory */

$this->title = Yii::t('app', 'Create Sp Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sp Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
