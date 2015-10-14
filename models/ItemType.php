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
class ItemType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_type_name', 'item_type_id'], 'required'],
            [['item_type_id'], 'integer'],
            [['item_type_name'], 'string', 'max' => 45]
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_type_name' => 'Item Type Name',
            'item_type_id' => 'Item Type Id',
        ];
    }

}
