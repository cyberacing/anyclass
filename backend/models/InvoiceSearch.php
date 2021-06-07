<?php
declare(strict_types=1);

namespace backend\models;

use common\models\Invoice;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * InvoiceSearch represents the model behind the search form of `common\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /** @var string Дата */
    public string $created_at = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['product_id', 'user_id'], 'string', 'max' => 255],
            [['created_at'], 'string',],
            [['amount'], 'number'],
            [['currency', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @throws \Exception
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = Invoice::find()->with(['product', 'user']);

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
            'invoice.id' => $this->id,
            'amount' => $this->amount,
        ]);

        if (!empty($this->created_at)) {
            $query->byCreatedAt($this->created_at);
        }

        $query->filterProduct((string)$this->product_id);
        $query->filterUser((string)$this->user_id);

        $query->filterCurrency($this->currency);

        return $dataProvider;
    }
}
