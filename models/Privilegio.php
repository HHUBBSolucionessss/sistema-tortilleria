<?php

namespace app\models;

use Yii;

class Privilegio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'privilegio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'movimientos_deposito', 'movimientos_boveda', 'apertura_caja', 'cierre_caja', 'movimientos_caja',
            'crear_cliente', 'modificar_cliente', 'eliminar_cliente',
            'crear_producto', 'modificar_producto', 'eliminar_producto',
            'crear_proveedor', 'modificar_proveedor', 'eliminar_proveedor',
            'crear_sucursal', 'modificar_sucursal', 'eliminar_sucursal',
            'crear_trabajador', 'modificar_trabajador', 'eliminar_trabajador',
            'crear_venta', 'pago_venta', 'cancelar_venta', 'crear_nomina', 'cancelar_nomina',
            'crear_cuenta', 'modificar_cuenta', 'eliminar_cuenta',
            'ver_banco', 'ver_boveda', 'ver_caja', 'ver_clientes', 'ver_venta', 'ver_productos', 'ver_devoluciones',
            'ver_sucursales', 'ver_trabajadores', 'ver_reportes', 'ver_nominas', 'ver_costales', 'ver_usuarios', 'ver_cuentas',
            'crear_usuario','modificar_usuario','eliminar_usuario','definir_privilegios', 'ver_registro_sistema'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'movimientos_caja' => Yii::t('app', 'Movimientos de Caja'),
            'apertura_caja' => Yii::t('app', 'Apertura de Caja'),
            'cierre_caja' => Yii::t('app', 'Cierre de Caja'),
            'crear_usuario' => Yii::t('app', 'Crear Usuario'),
            'modificar_usuario' => Yii::t('app', 'Modificar Usuario'),
            'eliminar_usuario' => Yii::t('app', 'Eliminar Usuario'),
            'definir_privilegios' => Yii::t('app', 'Definir Privilegios'),
            'ver_registro_sistema' => Yii::t('app', 'Ver Registro Sistema'),
        ];
    }
}
