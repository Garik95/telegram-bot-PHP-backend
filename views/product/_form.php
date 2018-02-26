<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\SpProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sp-product-form">

    <?php if($model->isNewRecord){
	$form = ActiveForm::begin(['action' =>['product/create','id' => $id], 'method' => 'post']); 
	}else
	$form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_Description')->textarea(['rows' => 6]) ?>

    <?= $form->field($price, 'Price')->textInput() ?>

    <?= $form->field($model, 'Product_calorie')->textInput() ?>

    <?= $form->field($model, 'product_Photo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'product_Video')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
