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
    /** @var string Дата */
    public string $created_at = '';

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['id'], 'integer'],
            [['title', 'updated_at'], 'safe'],
            [['created_at', 'currencies'], 'string',],
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
     * @throws \Exception
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
        ]);

        if (!empty($this->created_at)) {
            $query->byCreatedAt($this->created_at);
        }

        $query->andFilterWhere(['ilike', 'title', $this->title]);

        return $dataProvider;
    }
}
