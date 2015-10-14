<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Update Menu: ' . ' ' . $model->menu_id;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu_id, 'url' => ['view', 'id' => $model->menu_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'menuItems',
            'value' => 'menuItems.item_id'
            		],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    

</div>
