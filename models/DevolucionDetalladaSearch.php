<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DevolucionDetallada;

/**
 * DevolucionDetalladaSearch represents the model behind the search form of `app\models\DevolucionDetallada`.
 */
class DevolucionDetalladaSearch extends DevolucionDetallada
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_devolucion', 'id_producto', 'id_trabajador', 'id_cliente', 'cantidad'], 'integer'],
            [['precio'], 'number'],
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
        $query = DevolucionDetallada::find();

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
            'id_devolucion' => $this->id_devolucion,
            'id_producto' => $this->id_producto,
            'id_trabajador' => $this->id_trabajador,
            'id_cliente' => $this->id_cliente,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
        ]);

        return $dataProvider;
    }
}
