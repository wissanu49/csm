<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Withdraw;

/**
 * SearchWithdraw represents the model behind the search form of `app\models\Withdraw`.
 */
class SearchWithdraw extends Withdraw
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'products_id', 'users_id', 'price'], 'integer'],
            [['deposits_id', 'withdraw_id', 'void'], 'string'],
            [['date_withdraw'], 'safe'],
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
        $query = Withdraw::find()->groupBy('withdraw_id')->orderBy('withdraw_id DESC');

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
            'date_withdraw' => $this->date_withdraw,
            'withdraw_id' => $this->withdraw_id,
            'deposits_id' => $this->deposits_id,
            'users_id' => $this->users_id,
            'void' => $this->void,
        ]);

        return $dataProvider;
    }
}
