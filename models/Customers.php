<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $fullname ชื่อ-นามสกุล
 * @property string $address ที่อยู่
 * @property string $phone เบอร์ติดต่อ
 *
 * @property Deposits[] $deposits
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'address'], 'required'],
            [['address'], 'string'],
            [['fullname'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสลูกค้า',
            'fullname' => 'ชื่อ-นามสกุล',
            'address' => 'ที่อยู่',
            'phone' => 'หมายเลขติดต่อ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposits::className(), ['customers_id' => 'id']);
    }
    
    public function getCustomerData($id)
    {
        $get = Customers::find()->where('id=:id',[':id'=>$id])->all();
        return $get;
        
    }
}
