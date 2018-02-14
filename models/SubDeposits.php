<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_deposits".
 *
 * @property int $id
 * @property int $products_id รหัสสินค้า
 * @property int $amount จำนวน
 * @property int $deposits_id รหัสใบฝาก
 *
 * @property Deposits $deposits
 * @property Products $products
 */
class SubDeposits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const SCENARIO_UPDATE_BALANCE = 'updatebalance';
    
    public static function tableName()
    {
        return 'sub_deposits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'products_id', 'deposits_id', 'amount'], 'required'],
            [['id', 'products_id', 'amount', 'balance'], 'integer'],
            [['deposits_id'], 'string'],
            [['id'], 'unique'],
            [['deposits_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposits::className(), 'targetAttribute' => ['deposits_id' => 'id']],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products_id' => 'สินค้า',
            'amount' => 'จำนวน',
            'deposits_id' => 'เลขที่ใบฝากสินค้า',
            'balance' => 'คงเหลือ',
        ];
    }

    public function scenarios() {
        $sn = parent::scenarios();
        $sn[self::SCENARIO_UPDATE_BALANCE] = ['balance'];
        return $sn;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasOne(Deposits::className(), ['id' => 'deposits_id']);
    }
    
    public function getAmount($id , $pid)
    {
        $get = SubDeposits::find()->select('amount')->where('deposits_id=:id AND products_id=:pid',[':id'=>$id, ':pid'=>$pid])->one();
        return $get;
    }
    
    public function getBalance($id , $pid)
    {
        $get = SubDeposits::find()->select('balance')->where('deposits_id=:id AND products_id=:pid',[':id'=>$id, ':pid'=>$pid])->one();
        return $get;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }
}
