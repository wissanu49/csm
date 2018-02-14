<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property int $id
 * @property int $amount จำนวน
 * @property int $products_id
 * @property int $users_id
 *
 * @property Products $products
 * @property Users $users
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
   
    
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'products_id', 'users_id'], 'required'],
            [['id', 'amount', 'products_id', 'users_id'], 'integer'],
            [['session'],'string'],
            [['id'], 'unique'],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',            
            'amount' => 'จำนวน',
            'products_id' => 'สินค้า',
            'users_id' => 'ผู้ทำรายการ',
            'session' => 'Session',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }
    
    
}
