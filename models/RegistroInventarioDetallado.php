<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_inventario_detallado".
 *
 * @property int $id
 * @property int $id_registro
 * @property string $codigo
 * @property int $id_producto
 * @property int $cantidad_anterior
 * @property int $cantidad_actual
 * @property string $costo
 * @property string $precio
 */
class RegistroInventarioDetallado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_inventario_detallado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_registro', 'id_producto', 'cantidad_anterior', 'cantidad_actual', 'codigo', 'costo', 'precio'], 'required'],
            [['id_registro', 'id_producto', 'cantidad_anterior', 'cantidad_actual'], 'integer'],
            [['costo', 'precio'], 'number'],
            [['codigo'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Folio',
            'id_registro' => 'Registro',
            'codigo' => 'Código',
            'id_producto' => 'Producto',
            'cantidad_anterior' => 'Cantidad Anterior',
            'cantidad_actual' => 'Cantidad Actual',
            'costo' => 'Costo',
            'precio' => 'Precio',
        ];
    }
}
