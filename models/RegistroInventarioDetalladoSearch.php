<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistroInventarioDetallado;

/**
 * RegistroInventarioDetalladoSearch represents the model behind the search form of `app\models\RegistroInventarioDetallado`.
 */
class RegistroInventarioDetalladoSearch extends RegistroInventarioDetallado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_registro', 'id_producto', 'cantidad_anterior', 'cantidad_actual'], 'integer'],
            [['codigo'], 'safe'],
            [['costo', 'precio'], 'number'],
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
        $query = RegistroInventarioDetallado::find();

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
            'id_registro' => $this->id_registro,
            'id_producto' => $this->id_producto,
            'cantidad_anterior' => $this->cantidad_anterior,
            'cantidad_actual' => $this->cantidad_actual,
            'costo' => $this->costo,
            'precio' => $this->precio,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
