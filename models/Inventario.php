<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventario".
 *
 * @property int $id
 * @property int $id_producto
 * @property int $id_sucursal
 * @property int $cant
 * @property string $precio_medio_mayoreo
 * @property string $precio_mayoreo
 * @property string $precio_especial
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 */
class Inventario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_producto', 'id_sucursal', 'cant', 'precio_medio_mayoreo', 'precio_mayoreo', 'create_user', 'create_time'], 'required'],
            [['id_producto', 'id_sucursal', 'cant', 'create_user', 'update_user'], 'integer'],
            [['precio_medio_mayoreo', 'precio_mayoreo', 'precio_especial'], 'number'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_producto' => 'Producto',
            'id_sucursal' => 'Sucursal',
            'cant' => 'Cantidad',
            'precio_medio_mayoreo' => 'Precio Medio Mayoreo',
            'precio_mayoreo' => 'Precio Mayoreo',
            'precio_especial' => 'Precio Especial',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
            'update_user' => 'Update User',
            'update_time' => 'Update Time',
        ];
    }

    public function obtenerNombreProducto($id)
    {
      $model = Producto::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

}
