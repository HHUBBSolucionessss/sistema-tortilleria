<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "devolucion_detallada".
 *
 * @property int $id
 * @property int $id_devolucion
 * @property int $id_producto
 * @property int $id_trabajador
 * @property int $id_cliente
 * @property string $precio
 * @property int $cantidad
 */
class DevolucionDetallada extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'devolucion_detallada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_devolucion', 'id_producto', 'id_trabajador', 'id_cliente', 'precio', 'cantidad'], 'required'],
            [['id_devolucion', 'id_producto', 'id_trabajador', 'id_cliente', 'cantidad'], 'integer'],
            [['precio'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_devolucion' => 'Devolución',
            'id_producto' => 'Producto',
            'id_trabajador' => 'Trabajador',
            'id_cliente' => 'Cliente',
            'precio' => 'Precio',
            'cantidad' => 'Cantidad',
        ];
    }
}
