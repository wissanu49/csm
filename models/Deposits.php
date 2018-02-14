<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deposits".
 *
 * @property int $id
 * @property int $customers_id รหัสลูกค้า
 * @property string $deposit_date วันที่ฝาก
 * @property int $users_id ผู้บันทึก
 * @property string $comment หมายเหตุ
 *
 * @property Customers $customers
 * @property Users $users
 * @property SubDeposits[] $subDeposits
 * @property Withdraw[] $withdraws
 */
class Deposits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customers_id', 'deposit_date', 'users_id'], 'required'],
            [['customers_id', 'users_id'], 'integer'],
            [['deposit_date'], 'safe'],
            [['status'], 'string'],
            [['comment', 'id'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['customers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customers_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'เลขที่ใบฝาก',
            'customers_id' => 'ลูกค้า',
            'deposit_date' => 'วันที่รับเข้า',
            'users_id' => 'เจ้าหน้าที่ผู้ทำรายการ',
            'comment' => 'หมายเหตุ',
            'status' => 'สถานะ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasOne(Customers::className(), ['id' => 'customers_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubDeposits()
    {
        return $this->hasMany(SubDeposits::className(), ['deposits_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdraws()
    {
        return $this->hasMany(Withdraw::className(), ['deposits_id' => 'id']);
    }
    
    public function checkDocument($id){
        $get = Deposits::find()->select('id')->where('id=:id',[':id'=>$id])->one();
        if($get == NULL){
            return FALSE;
        }else{
            return TRUE;
        }
    }
}
