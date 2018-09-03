<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property int $id
 * @property int $id_proveedor
 * @property int $id_sucursal
 * @property int $id_comprador Utilizar trabajador_id
 * @property int $id_ctdestino
 * @property int $id_ctorigen
 * @property string $subtotal
 * @property string $impuesto
 * @property string $descuento
 * @property string $total
 * @property int $tipo_pago
 * @property string $num_cheque
 * @property string $beneficiario
 * @property string $folio_terminal
 * @property string $comision
 * @property string $referencia
 * @property string $concepto_pago
 * @property int $remision
 * @property int $factura
 * @property string $folio_remision
 * @property string $folio_factura
 * @property int $a_pagos
 * @property string $abonado
 * @property int $cancelada
 * @property int $estado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 * @property int $cancel_user
 * @property string $cancel_time
 */
class Compra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_proveedor', 'id_sucursal', 'id_comprador', 'id_ctdestino', 'id_ctorigen'], 'required'],
            [['id_proveedor', 'id_sucursal', 'id_comprador', 'id_ctdestino', 'id_ctorigen', 'tipo_pago', 'remision', 'factura', 'a_pagos', 'cancelada', 'estado', 'create_user', 'update_user', 'cancel_user'], 'integer'],
            [['subtotal', 'impuesto', 'descuento', 'total', 'comision', 'abonado'], 'number'],
            [['create_time', 'update_time', 'cancel_time'], 'safe'],
            [['num_cheque'], 'string', 'max' => 20],
            [['beneficiario', 'folio_terminal', 'folio_remision', 'folio_factura'], 'string', 'max' => 100],
            [['referencia', 'concepto_pago'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_proveedor' => 'Id Proveedor',
            'id_sucursal' => 'Id Sucursal',
            'id_comprador' => 'Id Comprador',
            'id_ctdestino' => 'Id Ctdestino',
            'id_ctorigen' => 'Id Ctorigen',
            'subtotal' => 'Subtotal',
            'impuesto' => 'Impuesto',
            'descuento' => 'Descuento',
            'total' => 'Total',
            'tipo_pago' => 'Tipo Pago',
            'num_cheque' => 'Num Cheque',
            'beneficiario' => 'Beneficiario',
            'folio_terminal' => 'Folio Terminal',
            'comision' => 'Comision',
            'referencia' => 'Referencia',
            'concepto_pago' => 'Concepto Pago',
            'remision' => 'Remision',
            'factura' => 'Factura',
            'folio_remision' => 'Folio Remision',
            'folio_factura' => 'Folio Factura',
            'a_pagos' => 'A Pagos',
            'abonado' => 'Abonado',
            'cancelada' => 'Cancelada',
            'estado' => 'Estado',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
            'update_user' => 'Update User',
            'update_time' => 'Update Time',
            'cancel_user' => 'Cancel User',
            'cancel_time' => 'Cancel Time',
        ];
    }
}
