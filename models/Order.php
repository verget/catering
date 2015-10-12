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
            [['order_name', 'order_user_id'], 'required'],
            [['order_date'], 'safe'],
            [['order_user_id', 'order_quests', 'order_location'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderUser()
    {
        return $this->hasOne(User::className(), ['id' => 'order_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHasItems()
    {
        return $this->hasMany(OrderHasItem::className(), ['order_order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemItems()
    {
        return $this->hasMany(Item::className(), ['item_id' => 'item_item_id'])->viaTable('order_has_item', ['order_order_id' => 'order_id']);
    }
}
