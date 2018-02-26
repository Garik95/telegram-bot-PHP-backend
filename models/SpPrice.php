<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_price".
 *
 * @property integer $Price_id
 * @property integer $product_id
 * @property double $Price
 * @property integer $State
 * @property string $v_date
 */
class SpPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'Price'], 'required'],
            [['product_id', 'State'], 'integer'],
            [['Price'], 'number'],
            [['v_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Price_id' => Yii::t('app', 'ID Цены'),
            'product_id' => Yii::t('app', 'ID Продукта'),
            'Price' => Yii::t('app', 'Цена'),
            'State' => Yii::t('app', 'Статус'),
            'v_date' => Yii::t('app', 'Дата'),
        ];
    }
}
