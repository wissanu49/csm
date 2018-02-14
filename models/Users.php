<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\View;
/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username ชื่อผู้ใช้
 * @property string $password รหัสผ่าน
 * @property string $fullname ชื่อ-นามสกุล
 * @property string $status สถานะ
 * @property string $role สิทธิ์การใช้งาน
 *
 * @property Deposits[] $deposits
 * @property Withdraw[] $withdraws
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $old_password;
    public $new_password;
    public $repeat_password;
    
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'fullname'], 'required'],
            [['status', 'role'], 'string'], 
            [['password', 'new_password', 'repeat_password'], 'required', 'on' => 'changepwd'],
            [['username', 'password', 'fullname', 'new_password', 'repeat_password' ], 'string', 'max' => 255],
        ];
    }
    
    public function scenarios() {
        $sn = parent::scenarios();
        //$sn['create'] = ['fullname', 'username', 'status', 'role'];
        $sn['update'] = ['fullname', 'username', 'status', 'role'];
        $sn['changepwd'] = ['new_password', 'repeat_password'];
        return $sn;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'fullname' => 'ชื่อ-นามสกุล',
            'status' => 'สถานะ',
            'role' => 'สิทธิ์การใช้งาน',
            //'old_password' => 'รหัสผ่านเดิม',
            'new_password' => 'รหัสผ่านใหม่',
            'repeat_password' => 'ยืนยันรหัสผ่านใหม่',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposits::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWithdraws()
    {
        return $this->hasMany(Withdraw::className(), ['users_id' => 'id']);
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id) {
         return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException();
    }
    
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
        //return $this->password === $password;
    }
    
    public static function findByUsername($username) {
        return self::findOne(['username' => $username, 'status' => 'Active']);
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) { // <---- the difference
                $this->authKey = Yii::$app->getSecurity()->generateRandomString();
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            } //else {
                //$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                //$this->authKey = Yii::$app->getSecurity()->generateRandomString();
            //}
            return true;
        }
        return false;
    }
    
    public function getRole() {
        $profile = Users::find()->where(['id' => $this->id])->one();
        if ($profile !== null) {
            return $profile->role;
        } else {
            return false;
        }
    }

}
