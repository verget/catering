<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Item;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'menu_type')->dropDownList(["doeuvres"=>"D'oeuvres", "reseption"=>"Reseption"]) ?>

    <?= $form->field($model, 'menu_price')->textInput() ?>

    <?= $form->field($model, 'menu_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'menu_desc')->widget(letyii\tinymce\Tinymce::className(), []) ?>
    
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
