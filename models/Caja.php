<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caja".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $efectivo
 * @property int $tipo_movimiento
 * @property int $tipo_pago
 * @property string $create_time
 * @property int $create_user
 */
class Caja extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['efectivo'], 'number'],
            [['tipo_movimiento', 'tipo_pago', 'create_user'], 'integer'],
            [['create_time'], 'safe'],
            [['create_user', 'efectivo', 'descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inicio' => 'Abrió con: $',
            'abrir_con' => 'Abrir con: $',
            'total_efectivo' => 'Total: $',
            'descripcion' => 'Descripción',
            'efectivo' => 'Efectivo',
            'tipo_movimiento' => 'Tipo Movimiento',
            'tipo_pago' => 'Tipo Pago',
            'create_time' => 'Fecha Creación',
            'create_user' => 'Registró',
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
              return 'Transferencia';
              break;
          case 2:
              return 'Cheque';
              break;
            default:
                return 'Sin información';
                break;
        }
	}


}
