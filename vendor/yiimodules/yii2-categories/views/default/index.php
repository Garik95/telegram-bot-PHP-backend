<?php
/*
 * This file is part of the YiiModules.com
 *
 * (c) Yii2 modules open source project are hosted on <http://github.com/yiimodules/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use yiimodules\categories\ModuleAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use yiimodules\categories\models\Categories;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Button;
use app\models\SpProductSearch;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->getModule('categories')->assets = ModuleAsset::register($this);
?>
<div class="page-header">
<h1>Категории</h1>
</div>

<div class="row">
	<div class="col-md-3">
	
<div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
	<a role="button" class="btn btn-default" href="<?php echo Yii::$app->urlManager->createUrl(['/categories']); ?>"><i class="glyphicon glyphicon-plus"></i> Категория</a>
	
	<?php if(Yii::$app->request->getQueryParam('parent_id')!=""): ?>
		<a role="button" class="btn btn-default disabled" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"></i> Подкатегория</a>
	<?php else: ?>
		<a <?php if ($model->parent_id!='') {?> style="pointer-events: none;color: #ccc;" <?php } ?> role="button" class="btn btn-default" href="<?php echo Yii::$app->urlManager->createUrl(['/categories','parent_id'=>Yii::$app->request->getQueryParam('id')]); ?>"><i class="glyphicon glyphicon-plus"></i> Подкатегория</a>
	<?php endif; ?>
</div>

			<div class="clearfix">&nbsp;</div>

		  <div id="yimd-categories-jstree">
		  <?php
		  $current_category = Yii::$app->request->getQueryParam('id');
		  ?>
		  <?php echo Categories::createTreeList($parent_id=0,$current_category); ?>
		  </div>	
	
	</div>
	<div class="col-md-9">

		<?php echo $this->render('_alert'); ?>

		<div class="categories-form tab-content" style="min-height:400px;">
		
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

			<nav class="navbar navbar-default navbar-static">
				<div class="container-fluid">
					<div class="navbar-header">
						<span class="navbar-brand">
							<?php if($parentCategory): ?>
							<?php echo Categories::printEditPath(Html::getAttributeValue($parentCategory,'id')); ?> - Новая подкатегория
							<?php else: ?>
								<?php if($model->id!=""): ?>
								<?php echo Categories::printEditPath(Html::getAttributeValue($model,'id')); ?> - Обновить информацию
								<?php else: ?>
								Новая категория
								<?php endif; ?>
							<?php endif; ?>
						</span>
					</div>
					<div class="pull-right" style="margin-top:8px">
					<?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
					<?php if (!$model->isNewRecord) echo Html::a('<i class="glyphicon glyphicon-trash"></i> Удалить',['default/delete','id'=>$model->id] ,['class' => 'btn btn-danger']) 
						?>
					</div>
				</div>
			</nav>			
			
		
			<?php
			$tabItems = [];
			if($model->id!=''){
				$tabItems[] = [
					'label' => 'Обзор',
					'content' => $this->render("_view",['model'=>$model,'form'=>$form]),
					'active' => true,
					'visible'=>($model->id=='') ? false : true
				];
			}
			
			$tabItems[] = [
				'label' => 'Информация',
				'content' => $this->render("_form_general",['model'=>$model,'form'=>$form]),
			];
			if($model->parent_id!='')
			{
				$searchModel = new SpProductSearch();
        		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$model->id);
				$tabItems[] = [
				'label' => 'Продукты',
				'content' => $this->render("//product/index",['searchModel' => $searchModel,
            'dataProvider' => $dataProvider,'model'=>$model]),
				];
			}
			/*$tabItems[] = [
				'label' => 'Category image',
				'content' => $this->render("_form_image",['model'=>$model,'form'=>$form]),
			];
			$tabItems[] = [
				'label' => 'Meta information (SEO)',
				'content' => $this->render("_form_seo",['model'=>$model,'form'=>$form]),
			];*/
			
/*			if($model->id!=''){
				$tabItems[] = [
					'label' => '<i class="glyphicon glyphicon-trash"></i> Удалить',
					'url' => Yii::$app->urlManager->createUrl(['categories/default/delete','id'=>$model->id]),
					'linkOptions' => ['onClick'=>'return confirm("Are you sure you want to delete this category?");']
				];
			}*/
			
			
			echo Tabs::widget([
				'items' => $tabItems,
				'encodeLabels'=>false
			]);
			?>

			<?php ActiveForm::end(); ?>

		</div>			
		
	</div>
</div>

<?php

$this->registerJs(' 
jQuery(document).ready(function(){
	jQuery("#yimd-categories-jstree").jstree();
	jQuery("#yimd-categories-jstree").bind(
		"select_node.jstree", function(evt, data){
			url = data.node.a_attr.href;
			window.location.href = url;
		}
	);
	jQuery("#categories-slug").slugify("#categories-name");
});', \yii\web\View::POS_READY);

?>
