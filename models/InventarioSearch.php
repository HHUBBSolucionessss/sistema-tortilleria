<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inventario;

/**
 * InventarioSearch represents the model behind the search form of `app\models\Inventario`.
 */
class InventarioSearch extends Inventario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_producto', 'id_sucursal', 'cant', 'create_user', 'update_user'], 'integer'],
            [['precio_medio_mayoreo', 'precio_mayoreo', 'precio_especial'], 'number'],
            [['create_time', 'update_time'], 'safe'],
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
        $query = Inventario::find();

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
            'id_producto' => $this->id_producto,
            'id_sucursal' => $this->id_sucursal,
            'cant' => $this->cant,
            'precio_medio_mayoreo' => $this->precio_medio_mayoreo,
            'precio_mayoreo' => $this->precio_mayoreo,
            'precio_especial' => $this->precio_especial,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
            'update_user' => $this->update_user,
            'update_time' => $this->update_time,
        ]);

        return $dataProvider;
    }
}
