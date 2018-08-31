<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "boveda".
 *
 * @property int $id
 * @property string $efectivo
 * @property string $descripcion
 * @property int $tipo_movimiento
 * @property int $create_user
 * @property string $create_time
 */
class Boveda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'boveda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['efectivo'], 'number'],
            [['descripcion'], 'required'],
            [['tipo_movimiento', 'create_user'], 'integer'],
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
            'efectivo' => 'Efectivo',
            'descripcion' => 'Descripción',
            'tipo_movimiento' => 'Tipo Movimiento',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
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
            case 1:
                return 'Tarjeta';
                break;
            case 2:
                return 'Transferencia';
                break;
            case 3:
                return 'Depósito';
                break;
            case 4:
                return 'Cheque';
                break;
              default:
                  return 'Sin información';
                  break;
          }
  	}

}
