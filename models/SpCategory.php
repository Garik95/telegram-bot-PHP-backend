<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sp_category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $indx
 */
class SpCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'indx'], 'integer'],
            [['name', 'indx'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'indx' => Yii::t('app', 'Indx'),
        ];
    }
    public function getParent()
    {
        return $this->hasOne(SpCategory::className(),['id'=>'parent_id']);
    }
}
