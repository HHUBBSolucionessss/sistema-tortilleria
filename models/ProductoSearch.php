<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Producto;

/**
 * ProductoSearch represents the model behind the search form of `app\models\Producto`.
 */
class ProductoSearch extends Producto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'proveedor_id', 'categoria', 'unidad', 'eliminado', 'create_user', 'update_user', 'delete_user'], 'integer'],
            [['nombre', 'marca', 'codigo', 'descripcion1', 'imagen', 'create_time', 'update_time', 'delete_time'], 'safe'],
            [['costo', 'precio', 'precio2'], 'number'],
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
        $query = Producto::find();

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
            'proveedor_id' => $this->proveedor_id,
            'categoria' => $this->categoria,
            'costo' => $this->costo,
            'precio' => $this->precio,
            'precio2' => $this->precio2,
            'unidad' => $this->unidad,
            'eliminado' => $this->eliminado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
            'update_user' => $this->update_user,
            'update_time' => $this->update_time,
            'delete_user' => $this->delete_user,
            'delete_time' => $this->delete_time,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion1', $this->descripcion1])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        $query->andFilterWhere(['eliminado' => 0 ]);

        return $dataProvider;
    }
}
