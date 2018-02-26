<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dispatch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dispatch-form">

    <?php $form = ActiveForm::begin(); ?>
	<br><br><br><br><br><br><br>
	<?= $form->field($model, 'text')->widget(\mervick\emojionearea\Widget::className(), []); ?>

    <? $form->field($model, 'data')->textInput(["maxlength"=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<!-- <div id="standalone" data-emoji-placeholder=":smiley:" class="centered"></div>
<input type="text" id="standalone" data-emoji-placeholder=":smiley:"/> -->
</div>
<?php
$this->registerJs('
  $("#standalone").emojioneArea({
    standalone: true,
    autocomplete: false
  });
')

?>
