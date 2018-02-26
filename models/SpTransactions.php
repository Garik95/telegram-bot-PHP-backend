<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_transactions".
 *
 * @property integer $transaction_id
 * @property integer $client_id
 * @property integer $product_id
 * @property double $price_id
 * @property string $v_date
 * @property integer $quantity
 * @property integer $state_id
 */
class SpTransactions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'product_id', 'price_id'], 'required'],
            [['client_id', 'product_id', 'quantity', 'state_id'], 'integer'],
            [['price_id'], 'number'],
            [['v_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => Yii::t('app', 'ID Транзакции'),
            'client_id' => Yii::t('app', 'ID Клиента'),
            'product_id' => Yii::t('app', 'ID Продукта'),
            'price_id' => Yii::t('app', 'ID Цены'),
            'v_date' => Yii::t('app', 'Дата заказа'),
            'quantity' => Yii::t('app', 'Количество'),
            'state_id' => Yii::t('app', 'ID Статуса'),
        ];
    }
public function getUserbyclientid()
{
return $this->hasOne(SpUsers::className(),['userid'=>'client_id']);
}
public function getUserbyid()
{
return $this->hasOne(SpUsers::className(),['id'=>'client_id']);
}
public function getProduct()
{
return $this->hasOne(SpProduct::className(),['product_id'=>'product_id']);
}
public function getStatus()
{
return $this->hasOne(SpTransactionState::className(),['state_id'=>'state_id']);
}
}
