<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Devoluciones;

/**
 * DevolucionesSearch represents the model behind the search form of `app\models\Devoluciones`.
 */
class DevolucionesSearch extends Devoluciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_cliente', 'id_sucursal', 'id_vendedor', 'create_user'], 'integer'],
            [['subtotal', 'total'], 'number'],
            [['notas', 'create_time'], 'safe'],
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
        $query = Devoluciones::find();

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
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'eliminado' => $this->eliminado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
        ]);

        $id_sucursal = Yii::$app->user->identity->id_sucursal;

        $query->andFilterWhere(['like', 'notas', $this->notas]);
        $query->andFilterWhere(['eliminado' => 0 ])
              ->andFilterWhere(['id_sucursal' => $id_sucursal]);

        return $dataProvider;
    }
}
