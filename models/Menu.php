<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $menu_id
 * @property integer $menu_type
 * @property double $menu_price
 * @property string $menu_name
 * @property string $menu_desc
 *
 * @property MenuHasItem[] $menuHasItems
 * @property Item[] $itemItems
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_type', 'menu_price', 'menu_name'], 'required'],
            [['menu_type'], 'string', 'max' => 50],
            [['menu_price'], 'number'],
            [['menu_name'], 'string', 'max' => 50],
            [['menu_desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'menu_type' => 'Menu Type',
            'menu_price' => 'Menu Price',
            'menu_name' => 'Menu Name',
            'menu_desc' => 'Menu Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuHasItems()
    {
        return $this->hasMany(MenuHasItem::className(), ['menu_menu_id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemItems()
    {
        return $this->hasMany(Item::className(), ['item_id' => 'item_item_id'])->viaTable('menu_has_item', ['menu_menu_id' => 'menu_id']);
    }
}
