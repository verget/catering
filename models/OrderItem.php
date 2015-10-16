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
            [['location_name', 'location_id'], 'required'],
            [['location_id'], 'integer'],
            [['location_name'], 'string', 'max' => 50]
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'location_name' => 'Location Name',
            'location_id' => 'Location id',
        ];
    }

}
