<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property int $id
 * @property string $date_withdraw วันที่เบิก
 * @property int $deposits_id รหัสใบฝาก
 * @property int $users_id ผู้บันทึก
 *
 * @property SubWithdraw[] $subWithdraws
 * @property Deposits $deposits
 * @property Users $users
 */
class Withdraw extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'withdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'withdraw_id', 'date_withdraw', 'deposits_id', 'users_id', 'products_id', 'price'], 'required'],
            [['id', 'products_id', 'users_id'], 'integer'],
            [['deposits_id'], 'string'],
            [['date_withdraw'], 'safe'],
            [['void'], 'string'],
            [[ 'price'], 'double'],
            [['id'], 'unique'],
            [['products_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['products_id' => 'id']],
            [['deposits_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposits::className(), 'targetAttribute' => ['deposits_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'withdraw_id' => 'เลขที่ใบเสร็จ/เบิกสินค้า',
            'date_withdraw' => 'วันที่ทำรายการ',
            'deposits_id' => 'เลขที่ใบฝาก',
            'users_id' => 'ผู้ทำรายการ',
            'products_id' => 'สินค้า',
            'amount' => 'จำนวน',
            'price' => 'ค่าฝากสินค้า',
            'void' => 'สถานะ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubWithdraws() {
        return $this->hasMany(SubWithdraw::className(), ['withdraw_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits() {
        return $this->hasOne(Deposits::className(), ['id' => 'deposits_id']);
    }

    public function getProducts() {
        return $this->hasOne(Products::className(), ['id' => 'products_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public function getAmount($id) {
        $get = Withdraw::find()->select('amount')->where('deposits_id=:id', [':id' => $id])->one();
        if ($sum == NULL) {
            //$get['amount'] = 0;
            return NULL;
        } else {
            return $sum;
        }
    }

    public function getRecjob($id) {
        $get = Withdraw::find()->where(['withdraw_id' => $id])->asArray()->all();;
        if ($get == NULL) {
            return NULL;
        } else {
            return $get;
        }
    }
    public function getMonthly_income() {

        $start = date("Y-m-d", strtotime("first day of this month"));
        $stop = date("Y-m-d", strtotime("last day of this month"));
        $command = Yii::$app->db->createCommand("SELECT sum(price) as income FROM withdraw WHERE void = 'false' AND date_withdraw BETWEEN '" . $start . "' AND '" . $stop . "'");
        $sum = $command->queryScalar();
        //die(var_dump($sum));
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getLastmonth_income() {

        $start = date("Y-m-d", strtotime("first day of last month"));
        $stop = date("Y-m-d", strtotime("last day of last month"));
        //die($start." ".$stop);
        $command = Yii::$app->db->createCommand("SELECT sum(price) as income FROM withdraw WHERE void = 'false' AND date_withdraw BETWEEN '" . $start . "' AND '" . $stop . "'");
        $sum = $command->queryScalar();
        //die(var_dump($sum));
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getToday_income() {

        $day = date("Y-m-d");
        $command = Yii::$app->db->createCommand("SELECT sum(price) as income FROM withdraw WHERE void = 'false' AND date_withdraw = '" . $day . "'");
        $sum = $command->queryScalar();
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getWeekly_income() {

        $day = date("Y-m-d");
        $weekly = \date("Y-m-d", \strtotime('-7 Day'));
        $command = Yii::$app->db->createCommand("SELECT sum(price) as income FROM withdraw WHERE void = 'false' AND date_withdraw BETWEEN '" . $weekly . "' AND '" . $day . "'");
        $sum = $command->queryScalar();
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getSummary_income() {


        $year = date('Y');
        $cm = date('m', strtotime('NOW'));
        switch ($cm) {
            case '01' :
                $query = 1;
                break;
            case '02' :
                $query = 2;
                break;
            case '03' :
                $query = 3;
                break;
            case '04' :
                $query = 4;
                break;
            case '05' :
                $query = 5;
                break;
            case '06' :
                $query = 6;
                break;
            case '07' :
                $query = 7;
                break;
            case '07' :
                $query = 8;
                break;
            case '09' :
                $query = 9;
                break;
            case '10' :
                $query = 10;
                break;
            case '11' :
                $query = 11;
                break;
            case '12' :
                $query = 12;
                break;
        }
        
        $ThaiMonth = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
        for ($i = 1; $i <= $query; $i++) {           
            
            $command = Yii::$app->db->createCommand("SELECT sum(price) as income FROM withdraw WHERE month(date_withdraw) = '" . $i . "' AND void = 'false'");
            $sum = $command->queryScalar();
            if ($sum== NULL) {
                $arrData[$i]['val'] = 0;
                $arrData[$i]['month'] = $ThaiMonth[$i];
            } else {
                $arrData[$i]['val'] = $sum;
                $arrData[$i]['month'] = $ThaiMonth[$i];;
            }
        }

        //die(var_dump($arrData));
        return $arrData;
    }

    public function getSumAmount($id, $pid) {
        $command = Yii::$app->db->createCommand("SELECT sum(amount) FROM withdraw WHERE deposits_id='" . $id . "' AND products_id='" . $pid . "' AND void = 'false'");
        $sum = $command->queryScalar();
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function Carts($id, $arrayData) {
        if (!isset($_SESSION['items'])) {
            $cart[$id] = [
                'depid' => $arrayData['depid'],
                'proid' => $arrayData['proid'],
                'amount' => $arrayData['amount'],
            ];
        } else {
            $cart = $_SESSION['items'];
            if (array_key_exists($id, $arrayData)) {
                $cart[$id] = [
                    'depid' => $arrayData['depid'],
                    'proid' => $arrayData['proid'],
                    'amount' => $arrayData['amount'],
                ];
            } else {
                $cart[$id] = [
                    'depid' => $arrayData['depid'],
                    'proid' => $arrayData['proid'],
                    'amount' => $arrayData['amount'],
                ];
            }
        }

        $_SESSION['items'] = $cart;
    }

    public function CheckDate($d) {
        $now = date('Y-m-d H:i:s');
        $date = $d . " 00:00:00";
        $days = (((strtotime($now) - strtotime($d)) / 60) / 60) / 24;
        return ceil($days / 30);
    }

    public function getTotalDate($d1, $d2) {
        $days = (((strtotime($d2) - strtotime($d1)) / 60) / 60) / 24;
        return ceil($days / 30);
    }
    
    public function checkDocument($id){
        $get = Withdraw::find()->select('withdraw_id')->where('withdraw_id=:id',[':id'=>$id])->one();
        if($get == NULL){
            return FALSE;
        }else{
            return TRUE;
        }
    }

}
