<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $name ชื่อสินค้า
 * @property int $price ราคา
 * @property int $units_id หน่วยนับ
 *
 * @property Units $units
 * @property SubDeposits[] $subDeposits
 * @property SubWithdraw[] $subWithdraws
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'units_id'], 'required'],
            [['name'], 'string'],
            [['price', 'units_id'], 'integer'],
            [['units_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['units_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ชื่อสินค้า',
            'price' => 'ราคาเช่าต่อเดือน',
            'units_id' => 'หน่วยนับ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasOne(Units::className(), ['id' => 'units_id']);
    }
    
    public function getPrice($id)
    {
        $get = Products::find()->select('price')->where('id=:id',[':id'=>$id])->one();
        return $get;
    }
    
    public function getProduct($id)
    {
        $get = Products::find()->select('name')->where('id=:id',[':id'=>$id])->one();
        return $get;
    }
    
    public function getProductInfo($id)
    {
        $get = Products::find()->where('id=:id',[':id'=>$id])->all();
        return $get;
    }
    
    public function getUnitId($id)
    {
        $get = Products::find()->select('units_id')->where('id=:id',[':id'=>$id])->one();
        return $get;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubDeposits()
    {
        return $this->hasMany(SubDeposits::className(), ['products_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubWithdraws()
    {
        return $this->hasMany(SubWithdraw::className(), ['products_id' => 'id']);
    }
}
