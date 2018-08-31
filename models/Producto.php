<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id
 * @property int $proveedor_id
 * @property int $categoria
 * @property string $nombre
 * @property string $marca
 * @property string $codigo
 * @property string $descripcion1
 * @property string $costo
 * @property string $precio
 * @property string $precio2
 * @property int $unidad Unidades para el producto -Pieza -Paquete
 * @property resource $imagen
 * @property int $eliminado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 * @property int $delete_user
 * @property string $delete_time
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proveedor_id', 'categoria', 'precio'], 'required'],
            [['proveedor_id', 'categoria', 'unidad', 'eliminado', 'create_user', 'update_user', 'delete_user'], 'integer'],
            [['costo', 'precio', 'precio2'], 'number'],
            [['imagen'], 'string'],
            [['create_time', 'update_time', 'delete_time'], 'safe'],
            [['nombre', 'marca', 'codigo', 'descripcion1'], 'string', 'max' => 45],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'proveedor_id' => 'ID Proveedor',
            'categoria' => 'Categoría',
            'nombre' => 'Nombre',
            'marca' => 'Marca',
            'codigo' => 'Código',
            'descripcion1' => 'Descripción',
            'costo' => 'Costo',
            'precio' => 'Precio',
            'precio2' => 'Precio 2',
            'unidad' => 'Unidad',
            'imagen' => 'Imagen',
            'eliminado' => 'Eliminado',
            'create_user' => 'Registró',
            'create_time' => 'Creado a las',
            'update_user' => 'Actualizó',
            'update_time' => 'Actualizado a las',
            'delete_user' => 'Delete User',
            'delete_time' => 'Delete Time',
        ];
    }
}
