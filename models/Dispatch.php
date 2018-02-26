<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dispatch".
 *
 * @property integer $id
 * @property string $text
 * @property string $data
 */
class Dispatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dispatch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'data' => Yii::t('app', 'Data'),
        ];
    }
}
