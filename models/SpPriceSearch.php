<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpPrice;

/**
 * SpPriceSearch represents the model behind the search form about `app\models\SpPrice`.
 */
class SpPriceSearch extends SpPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Price_id', 'product_id', 'State'], 'integer'],
            [['Price'], 'number'],
            [['v_date'], 'safe'],
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
    public function search($params)
    {
        $query = SpPrice::find();

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
            'Price_id' => $this->Price_id,
            'product_id' => $this->product_id,
            'Price' => $this->Price,
            'State' => $this->State,
        ]);

        $query->andFilterWhere(['like', 'v_date', $this->v_date]);

        return $dataProvider;
    }
}
