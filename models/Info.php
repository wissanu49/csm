<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property string $company_name
 * @property string $address
 * @property string $phone
 * @property string $logo
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'string'],
            [['company_name', 'phone', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_name' => 'ชื่อบริษัท',
            'address' => 'ที่อยู่',
            'phone' => 'เบอร์ติดต่อ',
            'logo' => 'โลโก้',
        ];
    }
}
