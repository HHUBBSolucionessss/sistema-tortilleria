<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta".
 *
 * @property int $id
 * @property int $id_cliente
 * @property int $id_sucursal
 * @property int $id_vendedor Utilizar trabajador_id
 * @property int $cancelada
 * @property int $abierta
 * @property string $subtotal
 * @property string $impuesto
 * @property string $descuento
 * @property string $total
 * @property string $saldo
 * @property int $remision
 * @property int $factura
 * @property string $folio_factura
 * @property int $tipo_pago
 * @property string $terminacion_tarjeta
 * @property string $terminal_tarjeta
 * @property string $cargo_tarjeta
 * @property string $folio_deposito
 * @property int $a_pagos
 * @property string $abonado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 * @property int $cancel_user
 * @property string $cancel_time
 */
class Venta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cliente', 'id_sucursal', 'terminacion_tarjeta', 'terminal_tarjeta'], 'required'],
            [['id_cliente', 'id_sucursal', 'id_vendedor', 'cancelada', 'abierta', 'remision', 'factura', 'tipo_pago', 'a_pagos', 'create_user', 'update_user', 'cancel_user'], 'integer'],
            [['subtotal', 'impuesto', 'descuento', 'total', 'saldo', 'cargo_tarjeta', 'abonado'], 'number'],
            [['create_time', 'update_time', 'cancel_time'], 'safe'],
            [['folio_factura'], 'string', 'max' => 30],
            [['terminacion_tarjeta', 'terminal_tarjeta'], 'string', 'max' => 50],
            [['folio_deposito'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cliente' => 'Id Cliente',
            'id_sucursal' => 'Id Sucursal',
            'id_vendedor' => 'Id Vendedor',
            'cancelada' => 'Cancelada',
            'abierta' => 'Abierta',
            'subtotal' => 'Subtotal',
            'impuesto' => 'Impuesto',
            'descuento' => 'Descuento',
            'total' => 'Total',
            'saldo' => 'Saldo',
            'remision' => 'Remision',
            'factura' => 'Factura',
            'folio_factura' => 'Folio Factura',
            'tipo_pago' => 'Tipo Pago',
            'terminacion_tarjeta' => 'Terminacion Tarjeta',
            'terminal_tarjeta' => 'Terminal Tarjeta',
            'cargo_tarjeta' => 'Cargo Tarjeta',
            'folio_deposito' => 'Folio Deposito',
            'a_pagos' => 'A Pagos',
            'abonado' => 'Abonado',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
            'update_user' => 'Update User',
            'update_time' => 'Update Time',
            'cancel_user' => 'Cancel User',
            'cancel_time' => 'Cancel Time',
        ];
    }
}
