<?php

use yii\helpers\Html;
use app\models\ItemType;


/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'item_types' => $item_types
    ]) ?>

</div>
