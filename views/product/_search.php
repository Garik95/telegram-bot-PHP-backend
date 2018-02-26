<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SpProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sp-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'product_name') ?>

    <?= $form->field($model, 'product_Description') ?>

    <?= $form->field($model, 'Product_calorie') ?>

    <?= $form->field($model, 'product_Photo') ?>

    <?php // echo $form->field($model, 'product_Video') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
