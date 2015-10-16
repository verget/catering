<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property string $order_name
 * @property string $order_date
 * @property integer $order_user_id
 * @property integer $order_quests
 * @property integer $order_location
 * @property double $order_price
 *
 * @property User $orderUser
 * @property OrderHasItem[] $orderHasItems
 * @property Item[] $itemItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_name', 'order_user_id', 'order_date', 'order_menu'], 'required'],
            [['order_date'], 'safe'],
            [['order_user_id', 'order_quests', 'order_location', 'order_menu'], 'integer'],
            [['order_price'], 'number'],
            [['order_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_name' => 'Order Name',
            'order_date' => 'Order Date',
            'order_user_id' => 'Order User ID',
            'order_quests' => 'Order Quests',
            'order_location' => 'Order Location',
            'order_price' => 'Order Price',
            'order_menu' => 'Order Menu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_order_id' => 'order_id']);
    }
    
    public function getOrderLocationName(){
        return $this->hasOne(OrderLocation::className(), ['location_id'=>'order_location']);
    }
    public function getOrderMenu(){
        return $this->hasOne(Menu::className(), ['menu_id'=>'order_menu']);
    }
    
    public function getOrderUser(){
        return $this->hasOne(User::className(), ['id'=>'order_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getItemItems()
//     {
//         return $this->hasMany(Item::className(), ['item_id' => 'item_item_id'])->viaTable('order_has_item', ['order_order_id' => 'order_id']);
//     }
}
