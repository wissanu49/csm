<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "void".
 *
 * @property int $id
 * @property string $type
 * @property string $void_id
 * @property string $status
 * @property string $date_request
 * @property string $date_action
 * @property string $comment
 */
class Void extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'void';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','type', 'void_id', 'date_request', 'users_id'], 'required'],
            [['users_id'], 'integer'],
            [['type', 'status', 'comment'], 'string'],
            [['date_request', 'date_action'], 'safe'],
            [['status', 'date_action', 'comment'],  'required', 'on' => 'action'],
            [['void_id'], 'string', 'max' => 15],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    public function scenarios() {
        $sn = parent::scenarios();
        $sn['action'] = ['status', 'date_action', 'comment'];
        return $sn;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'เลขที่',
            'type' => 'ประเภท',
            'void_id' => 'เลขที่เอกสาร',
            'status' => 'สถานะ',
            'date_request' => 'วันที่ส่งคำขอ',
            'date_action' => 'วันที่ตอบรับ',
            'comment' => 'หมายเหตุ',
            'users_id' => 'ผู้ส่งคำขอ',
        ];
    }
    
    
}
