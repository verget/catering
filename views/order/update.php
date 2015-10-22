<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Update Order: ' . ' ' . $model->order_name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_name, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'locations' => $locations,
        'all_menu' => $all_menu,
        'addons' => $addons,
        'order_items' => $order_items
    ]) ?>

</div>
