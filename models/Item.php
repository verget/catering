<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $item_id
 * @property string $item_name
 * @property integer $item_type
 * @property double $item_price
 * @property string $item_tarif
 *
 * @property MenuHasItem[] $menuHasItems
 * @property Menu[] $menuMenus
 * @property OrderHasItem[] $orderHasItems
 * @property Order[] $orderOrders
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'item_type'], 'required'],
            [['item_type'], 'integer'],
            [['item_price'], 'number'],
            [['item_name', 'item_tarif'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'item_name' => 'Item Name',
            'item_type' => 'Item Type',
            'item_price' => 'Item Price',
            'item_tarif' => 'Item Tarif',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuHasItems()
    {
        return $this->hasMany(MenuHasItem::className(), ['item_item_id' => 'item_id']);
    }
    
    public function getItemTypeName(){
        return $this->hasOne(ItemType::className(), ['item_type_id'=>'item_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getMenuMenus()
//     {
//         return $this->hasMany(Menu::className(), ['menu_id' => 'menu_menu_id'])->viaTable('menu_has_item', ['item_item_id' => 'item_id']);
//     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasItems()
    {
        return $this->hasMany(OrderHasItem::className(), ['item_item_id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//     public function getOrderOrders()
//     {
//         return $this->hasMany(Order::className(), ['order_id' => 'order_order_id'])->viaTable('order_has_item', ['item_item_id' => 'item_id']);
//     }
}
