<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Costales;

/**
 * CostalesSearch represents the model behind the search form of `app\models\Costales`.
 */
class CostalesSearch extends Costales
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'costales_ini', 'costales_fin', 'id_caja_ini', 'id_caja_fin'], 'integer'],
            [['id_sucursal'], 'required']
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
     */
    public function search($params)
    {
        $query = Costales::find();

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
            'id_sucursal' => $this->id_sucursal,
            'costales_ini' => $this->costales_ini,
            'costales_fin' => $this->costales_fin,
            'id_caja_ini' => $this->id_caja_ini,
            'id_caja_fin' => $this->id_caja_fin,
        ]);

        $id_sucursal = Yii::$app->user->identity->id_sucursal;
        $query->andFilterWhere(['id_sucursal' => $id_sucursal]);

        return $dataProvider;
    }
}
