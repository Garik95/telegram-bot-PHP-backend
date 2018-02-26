<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_product".
 *
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_Description
 * @property double $Product_calorie
 * @property string $product_Photo
 * @property string $product_Video
 */
class SpProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name'], 'required'],
            [['product_Description', 'product_Photo', 'product_Video'], 'string'],
            [['Product_calorie'], 'number'],
            [['product_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'ID Продукта'),
            'product_name' => Yii::t('app', 'Название продукта'),
            'product_Description' => Yii::t('app', 'Описание продукта'),
            'Product_calorie' => Yii::t('app', 'Калорийность'),
            'product_Photo' => Yii::t('app', 'Картинка'),
            'product_Video' => Yii::t('app', 'Видео'),
        ];
    }
    public function getPrice()
    {
        return $this->hasOne(SpPrice::className(),['product_id'=>'product_id']);
    }
}
