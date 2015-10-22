<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
use app\models\Menu;
use app\models\Item;


/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal', 'id'=>'save-order-form'],
                    'fieldConfig' => [
                                    'template' => '{label}<div class="col-sm-6">{input}</div><div class="col-sm-4">{error}</div>',
                                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    ],
    ]); ?>
    <div class="row">
        <div class="col-xs-8">
            <?= $form->field($model, 'order_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
   <div class="row">
        <div class="col-xs-8">
            <?= $form->field($model, 'order_date')->widget(DateTimePicker::className(), [
                            'size' => 'ms',
                            'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd MM yyyy - HH:ii P',
                                            'todayBtn' => true
                            ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <?= $form->field($model, 'order_guests')->textInput() ?>
        </div>
        <div class="col-xs-8">
            <?= $form->field($model, 'order_location')->dropDownList($locations, ['prompt' => "Select Location"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <?= $form->field($model, 'order_menu')->dropDownList($all_menu , ['prompt' => "Select Menu"]) ?>
        </div>
    </div>

    
    
     <div class="panel panel-default" id='order-items_panel' style="display: none;">
          <div class="panel-heading">Choise of <span id='menu-limit'><?php echo $model->orderMenu['menu_limit'];?></span> items</div>
          <div class="panel-body" id='order-items' >
            
          </div>
     </div>
    <div class="panel panel-default" id='order-menu_desc_panel' style="display: none;">
      <div class="panel-body">
        <p id="menu-desc"></p>
      </div>
    </div>
    <div class="panel panel-default" id='order-addons_panel'>
        <div class="panel-heading">Add Ons (check all that apply)</div>
        <div class="panel-body" id='order-addons' >
            <?php 
                
                foreach ($addons as $add){
                    $checked = "";
                    $count = '';
                    if (isset($order_items)){
                        if (array_key_exists($add['item_id'], $order_items)){
                            $checked = "checked";
                            $count = $order_items[$add['item_id']];
                        }
                    }
                    if ($add['item_tarif'] == 'dozen')
                       echo "<div class='col-sm-6 col-lg-4'><div class='row'><div class='col-xs-9'><div class='checkbox'><label><input type='checkbox' value='1' $checked name='Order[order_items][".$add['item_id']."]' 
                                class='order-addons' value='".$add['item_id']."'>".$add['item_name']."  ($".$add['item_price']."/".$add['item_tarif'].")</label></div></div>
                                            <div class='col-xs-3'><input type='text' name='Order[order_items][".$add['item_id']."]' placeholder='dozen' value='$count' class='order-addon-num'></div></div></div>";
                    else
                        echo "<div class='col-sm-6 col-lg-4'><div class='checkbox'><label><input type='checkbox' $checked value='1' name='Order[order_items][".$add['item_id']."]' 
                                class='order-addons' value='".$add['item_id']."'>".$add['item_name']."  ($".$add['item_price']."/".$add['item_tarif'].")</label></div></div>";
                }
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' , 'id' => 'save-order-btn' , 'data-order' => $model->order_id]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
