<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caja".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $efectivo
 * @property string $tarjeta
 * @property string $deposito
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
            [['efectivo', 'tarjeta', 'deposito'], 'number'],
            [['tipo_movimiento', 'tipo_pago', 'create_user', 'efectivo'], 'integer'],
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
            'tarjeta' => 'Tarjeta',
            'deposito' => 'Deposito',
            'tipo_movimiento' => 'Tipo Movimiento',
            'tipo_pago' => 'Tipo Pago',
            'create_time' => 'Fecha Creación',
            'create_user' => 'Registró',
        ];
    }

    /*public function obtenerTotalCaja()
  	{
  		$totalCaja=Yii::$app->db->createCommand('SELECT Sum(efectivo), sum(tarjeta), sum(deposito)');

      return $totalCaja;
      }*/

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
