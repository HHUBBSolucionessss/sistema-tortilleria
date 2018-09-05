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
 * @property int $cancel_user
 * @property string $cancel_time
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
            [['id_sucursal', 'estado', 'nota'], 'required'],
            [['id_sucursal', 'estado', 'create_user', 'cancel_user'], 'integer'],
            [['create_time', 'cancel_time'], 'safe'],
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
            'cancel_user' => 'Actualizó',
            'cancel_time' => 'Cancel Time',
        ];
    }
}
