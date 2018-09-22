<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "devoluciones".
 *
 * @property int $id
 * @property int $id_cliente
 * @property int $id_sucursal
 * @property int $id_vendedor
 * @property string $subtotal
 * @property string $total
 * @property string $notas
 * @property int $create_user
 * @property string $create_time
 */
class Devoluciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'devoluciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cliente', 'id_sucursal', 'id_vendedor', 'create_user'], 'required'],
            [['id_cliente', 'id_sucursal', 'id_vendedor', 'create_user'], 'integer'],
            [['subtotal', 'total'], 'number'],
            [['create_time', 'eliminado'], 'safe'],
            [['notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cliente' => 'Cliente',
            'id_sucursal' => 'Sucursal',
            'id_vendedor' => 'Vendedor',
            'subtotal' => 'Subtotal',
            'total' => 'Total',
            'notas' => 'Notas',
            'create_user' => 'Registró',
            'create_time' => 'Registrado',
        ];
    }

    public function obtenerNombreCliente($id)
    {
      $model = Cliente::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }
    public function obtenerNombreTrabajador($id)
    {
      $model = Trabajador::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }
    public function obtenerNombreSucursal($id)
    {
      $model = Sucursal::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

}
