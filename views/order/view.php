<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->order_name;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_name',
            'order_date',
            'orderUser.username',
            'orderMenu.menu_name',
            'order_quests',
            'orderLocationName.location_name',
            'order_price',
        ],
    ]) ?>
    
   <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo $model->orderMenu['menu_desc'];?>
              </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                With
              </div>
              <div class="panel-body">
                <?php 
                    $items = ArrayHelper::map($model->orderItems, 'item_id', 'item_name');
                    foreach ($items as $key => $value){
                        echo "<div class='col-xs-4'>$value</div>";
                    }
                ?>
              </div>
            </div>
        </div>
    </div>

</div>
