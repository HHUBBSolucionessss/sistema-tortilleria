<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compra;

/**
 * CompraSearch represents the model behind the search form of `app\models\Compra`.
 */
class CompraSearch extends Compra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_sucursal', 'id_cuenta', 'a_pagos', 'total_litros', 'create_user', 'estado'], 'integer'],
            [['limite_credito', 'nombre_proveedor', 'create_time'], 'safe'],
            [['precio_litro', 'total'], 'number'],
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
        $query = Compra::find();

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
            'id_cuenta' => $this->id_cuenta,
            'a_pagos' => $this->a_pagos,
            'total_litros' => $this->total_litros,
            'precio_litro' => $this->precio_litro,
            'total' => $this->total,
            'estado' => $this->estado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
        ]);

        $id_sucursal = Yii::$app->user->identity->id_sucursal;

        $query->andFilterWhere(['like', 'limite_credito', $this->limite_credito])
            ->andFilterWhere(['like', 'nombre_proveedor', $this->nombre_proveedor])
            ->andFilterWhere(['id_sucursal' => $id_sucursal]);

        return $dataProvider;
    }
}
