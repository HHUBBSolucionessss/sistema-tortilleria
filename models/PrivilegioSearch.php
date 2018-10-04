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
            'crear_cuenta' => $this->crear_cuenta,
            'modificar_cuenta' => $this->modificar_cuenta,
            'eliminar_cuenta' => $this->eliminar_cuenta,
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
            'crear_devolucion' => $this->crear_devolucion,
            'eliminar_devolucion' => $this->eliminar_devolucion,
            'crear_trabajador' => $this->crear_trabajador,
            'modificar_trabajador' => $this->modificar_trabajador,
            'eliminar_trabajador' => $this->eliminar_trabajador,
            'crear_usuario' => $this->crear_usuario,
            'modificar_usuario' => $this->modificar_usuario,
            'eliminar_usuario' => $this->eliminar_usuario,
            'crear_compra' => $this->crear_compra,
            'modificar_compra' => $this->modificar_compra,
            'eliminar_compra' => $this->eliminar_compra,
            'ver_compra' => $this->ver_compra,
            'crear_nomina' => $this->crear_nomina,
            'cancelar_nomina' => $this->cancelar_nomina,
            'definir_privilegios' => $this->definir_privilegios,
            'ver_registro_sistema' => $this->ver_registro_sistema,
            'ver_banco' => $this->ver_banco,
            'ver_boveda' => $this->ver_boveda,
            'ver_caja' => $this->ver_caja,
            'ver_cuentas' => $this->ver_cuentas,
            'ver_clientes' => $this->ver_clientes,
            'ver_venta' => $this->ver_venta,
            'ver_productos' => $this->ver_productos,
            'ver_devoluciones' => $this->ver_devoluciones,
            'ver_sucursales' => $this->ver_sucursales,
            'ver_trabajadores' => $this->ver_trabajadores,
            'ver_reportes' => $this->ver_reportes,
            'ver_nominas' => $this->ver_nominas,
            'ver_costales' => $this->ver_costales,
            'ver_usuarios' => $this->ver_usuarios,

        ]);

        return $dataProvider;
    }
}
