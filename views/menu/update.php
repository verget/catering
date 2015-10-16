<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\controllers\ItemController;
use app\models\Item;



/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Update Menu: ' . ' ' . $model->menu_name;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu_name, 'url' => ['view', 'id' => $model->menu_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
    
    <div class="row">
        <div class = "col-xs-4" id="menu_items_select">
             <?php 
             
                $items = ArrayHelper::map(Item::find()->joinWith(['itemTypeName'])->all(), 'item_id', 'item_name', 'itemTypeName.item_type_name');
                $params = ['multiple' => 'true'];
        
                echo Html::activeDropDownList($model, 'menuItems', $items, $params);
             ?>
        </div>
        <div class="col-xs-2"><button class="btn btn-primary" id='add_to_menu' data-menu="<?php echo $model->menu_id?>"> Add Items </button></div>
    </div>
    <br>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item_id',
            'item_name',
            'item_price',
            'item_tarif',
            'itemTypeName.item_type_name',
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                        'delete' => function ($url, $object) {
                        return Html::button('Del',[
                                        'class' => 'btn btn-sm btn-danger del_from_menu',
                                        'data-item' => $object->item_id
                            ]);
                        },
                        ],
                    ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
