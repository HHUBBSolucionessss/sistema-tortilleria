<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banco".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $id_cuenta
 * @property string $descripcion
 * @property int $tipo_movimiento
 * @property int $create_user
 * @property string $create_time
 */
class Banco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'id_cuenta', 'deposito', 'descripcion'], 'required'],
            [['id_sucursal', 'id_cuenta', 'tipo_movimiento', 'create_user'], 'integer'],
            [['deposito'], 'number'],
            [['create_time'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sucursal' => 'Sucursal',
            'id_cuenta' => 'Cuenta',
            'deposito' => 'Efectivo',
            'descripcion' => 'Descripción',
            'tipo_movimiento' => 'Tipo Movimiento',
            'create_user' => 'Registró',
            'create_time' => 'Registrado',
        ];
    }

    public function obtenerTipoMovimiento($key)
      {
          switch ($key) {
              case 0:
                  return 'Entrada';
                  break;
              case 1:
                  return 'Salida';
                  break;
              default:
                  return 'Sin información';
                  break;
          }
  	}

    public function obtenerTipoPago($key)
      {
          switch ($key) {
            case 0:
                return 'Efectivo';
                break;
              default:
                  return 'Sin información';
                  break;
          }
  	}

}
