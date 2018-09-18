<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_inventario".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $estado
 * @property string $nota
 * @property int $create_user
 * @property string $create_time
 */
class RegistroInventario extends \yii\db\ActiveRecord
{
  public $buscar;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_inventario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal'], 'required'],
            [['id_sucursal', 'estado', 'create_user'], 'integer'],
            [['create_time'], 'safe'],
            [['nota'], 'string', 'max' => 255],
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
            'estado' => 'Estado',
            'nota' => 'Nota',
            'create_user' => 'Registró',
            'create_time' => 'Registrado a las',
        ];
    }

    public function obtenerNombreSucursal($id)
    {
      $model = Sucursal::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

    public function obtenerEstado($estado)
    {
        switch ($estado) {
            case 0:
                return 'Inactivo';
                break;
            case 1:
                return 'Activo';
                break;
            default:
                return 'Sin información';
                break;
        }
	}

}
