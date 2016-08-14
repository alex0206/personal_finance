<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Expense;

/**
 * ExpenseSearch represents the model behind the search form about `app\models\Expense`.
 */
class ExpenseSearch extends Expense
{
    public $form = null;
    public $limit = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expense_id', 'category_id', 'value', 'limit'], 'integer'],
            [['comment'], 'string'],
            [['date'], 'safe'],
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
        $query = Expense::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => ['date' => SORT_DESC],
            ],
        ]);

        $this->load($params, $this->form);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'expense_id'  => $this->expense_id,
            'category_id' => $this->category_id,
            'value'       => $this->value,
            'date'        => $this->date,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        if ($this->limit) {
            $query->limit($this->limit);
        }

        return $dataProvider;
    }
}
