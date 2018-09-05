<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form of `app\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sucursal_id', 'cuenta_id', 'tipo', 'eliminado', 'create_user', 'update_user', 'delete_user'], 'integer'],
            [['nombre', 'rfc', 'calle', 'num_ext', 'num_int', 'colonia', 'ciudad', 'estado', 'cp', 'telefono1', 'create_time', 'update_time', 'delete_time'], 'safe'],
            [['limite_credito'], 'number'],
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
        $query = Cliente::find();

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
            'sucursal_id' => $this->sucursal_id,
            'cuenta_id' => $this->cuenta_id,
            'tipo' => $this->tipo,
            'limite_credito' => $this->limite_credito,
            'eliminado' => $this->eliminado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
            'update_user' => $this->update_user,
            'update_time' => $this->update_time,
            'delete_user' => $this->delete_user,
            'delete_time' => $this->delete_time,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'calle', $this->calle])
            ->andFilterWhere(['like', 'colonia', $this->colonia])
            ->andFilterWhere(['like', 'ciudad', $this->ciudad])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'cp', $this->cp])
            ->andFilterWhere(['like', 'telefono1', $this->telefono1]);

        $query->andFilterWhere(['eliminado' => 0 ]);

        return $dataProvider;
    }
}
