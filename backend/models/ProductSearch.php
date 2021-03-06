<?php
declare(strict_types=1);

namespace backend\models;

use common\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /** @var string Дата */
    public string $created_at = '';

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['id'], 'integer'],
            [['title', 'currency', 'updated_at'], 'safe'],
            [['created_at'], 'string',],
            [['price'], 'number'],
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
     * @throws \Exception
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = Product::find();

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
            'price' => $this->price,
        ]);

        if (!empty($this->created_at)) {
            $query->byCreatedAt($this->created_at);
        }

        $query->andFilterWhere(['ilike', 'title', $this->title]);
        $query->filterCurrency($this->currency);

        return $dataProvider;
    }
}
