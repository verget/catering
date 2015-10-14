<?php

namespace app\models;

use Yii;


class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'item_id'], 'required'],
            [['menu_id', 'item_id'], 'integer'],
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'item_id' => 'Item ID',
        ];
    }
   
}
