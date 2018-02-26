<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpProduct;

/**
 * SpProductSearch represents the model behind the search form about `app\models\SpProduct`.
 */
class SpProductSearch extends SpProduct
{
    /**
     * @inheritdoc
     */
    public $www;

    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['product_name', 'product_Description', 'product_Photo', 'product_Video'], 'safe'],
            [['Product_calorie'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$id='')
    {
        if($id!='')
            $query = SpProduct::find()->where(['sp_category_id'=>$id]);
        if($id=='')
            $query = SpProduct::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product_id' => $this->product_id,
            'Product_calorie' => $this->Product_calorie,
        ]);

        $query->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_Description', $this->product_Description])
            ->andFilterWhere(['like', 'product_Photo', $this->product_Photo])
            ->andFilterWhere(['like', 'product_Video', $this->product_Video]);

        return $dataProvider;
    }
}
