<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\Caja;

/**
 * CajaSearch represents the model behind the search form of `app\models\Caja`.
 */
class CajaSearch extends Caja
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_user'], 'integer'],
            [['descripcion', 'create_time'], 'safe'],
            [['efectivo', 'tipo_movimiento', 'tipo_pago'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
public function buscarMovimientosCierre($params)
{

    $aperturaCaja = Caja::find()
    ->where(['descripcion' => 'Apertura de caja'])
    ->max('id');

    $cierreCaja = Caja::find()
    ->where(['descripcion' => 'Cierre de caja'])
    ->max('id');

    $query = Caja::find()
    ->where(['between', 'id', $aperturaCaja, $cierreCaja]);

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [ 'pageSize' => 'all' ],
    ]);

    return $dataProvider;
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
    $query = Caja::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [ 'pageSize' => 'all' ],
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
        'efectivo' => $this->efectivo,
        'tipo_movimiento' => $this->tipo_movimiento,
        'tipo_pago' => $this->tipo_pago,
        'create_time' => $this->create_time,
        'create_user' => $this->create_user,
    ]);

    $id_sucursal = Yii::$app->user->identity->id_sucursal;

    $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
          ->andFilterWhere(['id_sucursal' => $id_sucursal]);


    return $dataProvider;
}

}
