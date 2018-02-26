<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_transaction_state".
 *
 * @property integer $state_id
 * @property string $name_state
 */
class SpTransactionState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_transaction_state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_state'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state_id' => Yii::t('app', 'ID'),
            'name_state' => Yii::t('app', 'Название Статуса'),
        ];
    }
}
