<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nomina;

/**
 * NominaSearch represents the model behind the search form of `app\models\Nomina`.
 */
class NominaSearch extends Nomina
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_sucursal', 'id_trabajador', 'dias_trabajados', 'eliminado', 'create_user'], 'integer'],
            [['sueldo_base', 'descuentos', 'sueldo', 'bonos'], 'number'],
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
        $query = Nomina::find();

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
            'id_trabajador' => $this->id_trabajador,
            'sueldo_base' => $this->sueldo_base,
            'descuentos' => $this->descuentos,
            'sueldo' => $this->sueldo,
            'bonos' => $this->bonos,
            'dias_trabajados' => $this->dias_trabajados,
            'eliminado' => $this->eliminado,
            'create_user' => $this->create_user,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'notas', $this->notas]);

        $query->andFilterWhere(['eliminado' => 0 ]);

        return $dataProvider;
    }
}
