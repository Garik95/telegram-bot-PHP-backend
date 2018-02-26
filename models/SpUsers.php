<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_users".
 *
 * @property integer $userid
 * @property string $first_name
 * @property string $last_name
 * @property string $language_code
 * @property string $username
 * @property integer $status
 */
class SpUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'first_name', 'last_name', 'language_code', 'username', 'status'], 'required'],
            [['userid', 'status'], 'integer'],
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
            'userid' => Yii::t('app', 'Userid'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'language_code' => Yii::t('app', 'Код языка'),
            'username' => Yii::t('app', 'Имя пользователья'),
            'status' => Yii::t('app', 'Статус'),
        ];
    }
}
