<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $id_cuenta
 * @property int $a_pagos
 * @property string $limite_credito
 * @property string $nombre_proveedor
 * @property int $total_litros
 * @property string $precio_litro
 * @property string $total
 * @property int $create_user
 * @property string $create_time
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
            [['id_sucursal', 'id_cuenta', 'nombre_proveedor', 'create_user', 'total_litros', 'precio_litro', 'total'], 'required'],
            [['id_sucursal', 'id_cuenta', 'a_pagos', 'total_litros', 'create_user', 'estado'], 'integer'],
            [['precio_litro', 'total'], 'number'],
            [['create_time'], 'safe'],
            [['limite_credito'], 'string', 'max' => 10],
            [['nombre_proveedor'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Folio',
            'id_sucursal' => 'Sucursal',
            'id_cuenta' => 'Cuenta',
            'a_pagos' => 'A Pagos',
            'limite_credito' => 'Límite Crédito',
            'nombre_proveedor' => 'Nombre Proveedor',
            'total_litros' => 'Total Litros',
            'precio_litro' => 'Precio Litro',
            'estado' => 'Estado',
            'total' => 'Total $',
            'create_user' => 'Registró',
            'create_time' => 'Creado',
        ];
    }

    public function obtenerNombreSucursal($id)
    {
      $model = Sucursal::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

    public function obtenerCuenta($id)
    {
      $model = Cuenta::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

    public function obtenerTipoPago($key)
    {
        switch ($key) {
          case 0:
              return 'No';
              break;
          case 1:
              return 'Sí';
              break;
          default:
              return 'Sin información';
              break;
        }
	}
}
