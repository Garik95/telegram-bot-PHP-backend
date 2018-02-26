<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Tree;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SpCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sp Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sp Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php use kartik\tree\TreeView;
echo TreeView::widget([
    // single query fetch to render the tree
    'query'             => Tree::find()->addOrderBy('root, lft'), 
    'headingOptions'    => ['label' => 'Categories'],
    'isAdmin'           => false,                       // optional (toggle to enable admin mode)
    'displayValue'      => 1,                           // initial display value
    //'softDelete'      => true,                        // normally not needed to change
    //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
]); 
use kartik\tree\TreeViewInput;
echo TreeViewInput::widget([
    // single query fetch to render the tree
    'query'             => Tree::find()->addOrderBy('root, lft'), 
    'headingOptions'    => ['label' => 'Categories'],
    'name'              => 'kv-product',    // input name
    'value'             => '1,2,3',         // values selected (comma separated for multiple select)
    'asDropdown'        => true,            // will render the tree input widget as a dropdown.
    'multiple'          => true,            // set to false if you do not need multiple selection
    'fontAwesome'       => true,            // render font awesome icons
    'rootOptions'       => [
        'label' => '<i class="fa fa-tree"></i>', 
        'class'=>'text-success'
    ],                                      // custom root label
    //'options'         => ['disabled' => true],
]);

?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'parent_id',
                'value' => 'parent.name',
            ],
            'name',
            'indx',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
