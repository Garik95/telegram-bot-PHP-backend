<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property integer $staff_id
 * @property string $first_name
 * @property string $last_name
 * @property string $language_code
 * @property string $username
 * @property integer $status
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'language_code', 'username'], 'required'],
            [['status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['language_code'], 'string', 'max' => 5],
            [['username'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => Yii::t('app', 'Staff ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'language_code' => Yii::t('app', 'Language Code'),
            'username' => Yii::t('app', 'Username'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
