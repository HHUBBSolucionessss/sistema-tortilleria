<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Privilegio;

/**
 * PrivilegioSearch represents the model behind the search form of `app\models\Privilegio`.
 */
class PrivilegioSearch extends Privilegio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario',
            'movimientos_caja', 'apertura_caja', 'cierre_caja',
            'crear_usuario', 'modificar_usuario', 'eliminar_usuario', 'definir_privilegios'], 'integer'],
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
        $query = Privilegio::find();

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
            'id_usuario' => $this->id_usuario,
            'movimientos_deposito' => $this->movimientos_deposito,
            'movimientos_boveda' => $this->movimientos_boveda,
            'movimientos_caja' => $this->movimientos_caja,
            'apertura_caja' => $this->apertura_caja,
            'cierre_caja' => $this->cierre_caja,
            'crear_cliente' => $this->crear_cliente,
            'modificar_cliente' => $this->modificar_cliente,
            'eliminar_cliente' => $this->eliminar_cliente,
            'crear_producto' => $this->crear_producto,
            'modificar_producto' => $this->modificar_producto,
            'eliminar_producto' => $this->eliminar_producto,
            'crear_inventario' => $this->crear_inventario,
            'crear_venta' => $this->crear_venta,
            'pago_venta' => $this->pago_venta,
            'cancelar_venta' => $this->cancelar_venta,
            'crear_proveedor' => $this->crear_proveedor,
            'modificar_proveedor' => $this->modificar_proveedor,
            'eliminar_proveedor' => $this->eliminar_proveedor,
            'crear_sucursal' => $this->crear_sucursal,
            'modificar_sucursal' => $this->modificar_sucursal,
            'eliminar_sucursal' => $this->eliminar_sucursal,
            'crear_trabajador' => $this->crear_trabajador,
            'modificar_trabajador' => $this->modificar_trabajador,
            'eliminar_trabajador' => $this->eliminar_trabajador,
            'crear_usuario' => $this->crear_usuario,
            'modificar_usuario' => $this->modificar_usuario,
            'eliminar_usuario' => $this->eliminar_usuario,
            'definir_privilegios' => $this->definir_privilegios,
            'ver_registro_sistema' => $this->ver_registro_sistema,

        ]);

        return $dataProvider;
    }
}
