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
            [['id', 'id_proveedor', 'id_sucursal', 'id_comprador', 'id_ctdestino', 'id_ctorigen', 'tipo_pago', 'remision', 'factura', 'a_pagos', 'cancelada', 'estado', 'create_user', 'update_user', 'cancel_user'], 'integer'],
            [['subtotal', 'impuesto', 'descuento', 'total', 'comision', 'abonado'], 'number'],
            [['num_cheque', 'beneficiario', 'folio_terminal', 'referencia', 'concepto_pago', 'folio_remision', 'folio_factura', 'create_time', 'update_time', 'cancel_time'], 'safe'],
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
            'id_proveedor' => $this->id_proveedor,
            'id_sucursal' => $this->id_sucursal,
            'id_comprador' => $this->id_comprador,
            'id_ctdestino' => $this->id_ctdestino,
            'id_ctorigen' => $this->id_ctorigen,
            'subtotal' => $this->subtotal,
            'impuesto' => $this->impuesto,
            'descuento' => $this->descuento,
            'total' => $this->total,
            'tipo_pago' => $this->tipo_pago,
            'comision' => $this->comision,
            'remision' => $this->remision,
            'factura' => $this->factura,
            'a_pagos' => $this->a_pagos,
            'abonado' => $this->abonado,
            'cancelada' => $this->cancelada,
            'estado' => $this->estado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
            'update_user' => $this->update_user,
            'update_time' => $this->update_time,
            'cancel_user' => $this->cancel_user,
            'cancel_time' => $this->cancel_time,
        ]);

        $query->andFilterWhere(['like', 'num_cheque', $this->num_cheque])
            ->andFilterWhere(['like', 'beneficiario', $this->beneficiario])
            ->andFilterWhere(['like', 'folio_terminal', $this->folio_terminal])
            ->andFilterWhere(['like', 'referencia', $this->referencia])
            ->andFilterWhere(['like', 'concepto_pago', $this->concepto_pago])
            ->andFilterWhere(['like', 'folio_remision', $this->folio_remision])
            ->andFilterWhere(['like', 'folio_factura', $this->folio_factura]);

        return $dataProvider;
    }
}
