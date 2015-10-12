<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ItemType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_id',
            'item_name',
            'itemTypeName.item_type_name',
            'item_price',
            'item_tarif',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
