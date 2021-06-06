<?php
declare(strict_types=1);

namespace backend\models;

use common\models\PaymentSystem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PaymentSystemSearch represents the model behind the search form of `common\models\PaymentSystem`.
 */
class PaymentSystemSearch extends PaymentSystem
{
    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['id'], 'integer'],
            [['title', 'currencies', 'created_at', 'updated_at'], 'safe'],
            [['active'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() : array
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
    public function search(array $params) : ActiveDataProvider
    {
        $query = PaymentSystem::find();

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
            'id' => $this->id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
              ->andFilterWhere(['ilike', 'currencies', $this->currencies]);

        return $dataProvider;
    }
}
