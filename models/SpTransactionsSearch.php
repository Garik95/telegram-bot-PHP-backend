<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpTransactions;

/**
 * SpTransactionsSearch represents the model behind the search form about `app\models\SpTransactions`.
 */
class SpTransactionsSearch extends SpTransactions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'client_id', 'product_id', 'quantity', 'state_id'], 'integer'],
            [['price_id'], 'number'],
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
        $query = SpTransactions::find()->where(['>','state_id',1])->andWhere(['<','state_id',5])->orderBy(['client_id'=>SORT_ASC]);

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
            'transaction_id' => $this->transaction_id,
            'client_id' => $this->client_id,
            'product_id' => $this->product_id,
            'price_id' => $this->price_id,
            'quantity' => $this->quantity,
            'state_id' => $this->state_id,
        ]);

        $query->andFilterWhere(['like', 'v_date', $this->v_date]);

        return $dataProvider;
    }
}
