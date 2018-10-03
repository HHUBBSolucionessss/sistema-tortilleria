<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RegistroSistema;

/**
 * RegistroSistemaSearch represents the model behind the search form of `app\models\RegistroSistema`.
 */
class RegistroSistemaSearch extends RegistroSistema
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_sucursal'], 'integer'],
            [['descripcion', 'create_time'], 'safe'],
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
        $query = RegistroSistema::find();

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
            'create_time' => $this->create_time,
        ]);
        
        $id_sucursal = Yii::$app->user->identity->id_sucursal;
        
        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['id_sucursal' => $id_sucursal]);
            
            return $dataProvider;
}
}
