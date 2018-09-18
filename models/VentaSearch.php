<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Venta;

/**
 * VentaSearch represents the model behind the search form of `app\models\Venta`.
 */
class VentaSearch extends Venta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_cliente', 'id_sucursal', 'id_vendedor', 'cancelada', 'a_pagos', 'create_user', 'update_user', 'cancel_user'], 'integer'],
            [['subtotal', 'descuento', 'total', 'saldo'], 'number'],
            [['create_time', 'update_time', 'cancel_time'], 'safe'],
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
        $query = Venta::find();

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
            'id_cliente' => $this->id_cliente,
            'id_sucursal' => $this->id_sucursal,
            'id_vendedor' => $this->id_vendedor,
            'cancelada' => $this->cancelada,
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'total' => $this->total,
            'saldo' => $this->saldo,
            'a_pagos' => $this->a_pagos,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
            'update_user' => $this->update_user,
            'update_time' => $this->update_time,
            'cancel_user' => $this->cancel_user,
            'cancel_time' => $this->cancel_time,
        ]);

        return $dataProvider;
    }

}
