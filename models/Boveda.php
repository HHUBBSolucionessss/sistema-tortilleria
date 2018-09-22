<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "boveda".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $efectivo
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
            [['descripcion', 'tipo_movimiento', 'create_user'], 'required'],
            [['efectivo'], 'number'],
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
            'descripcion' => 'Descripción',
            'efectivo' => 'Efectivo',
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

}
