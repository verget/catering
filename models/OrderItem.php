<?php

namespace app\models;

use Yii;


class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id'], 'required'],
            [['order_id', 'item_id', 'menu_id', 'count'], 'integer'],
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order',
            'item_id' => 'Item',
            'menu_id' => 'Menu ',
            'count' => 'Count',
        ];
    }
    
    public function getItem(){
        return $this->hasOne(Item::className(), ['item_id'=>'item_id']);
    }

}
