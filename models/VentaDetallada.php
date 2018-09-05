<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venta_detallada".
 *
 * @property int $id_venta
 * @property int $id_producto
 * @property int $id_sucursal
 * @property int $cant
 * @property string $precio
 * @property string $descuento
 * @property int $unidad
 * @property int $paquete
 * @property int $id_promocion
 */
class VentaDetallada extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venta_detallada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'id_producto', 'cant', 'precio', 'descuento', 'id_promocion'], 'required'],
            [['id_venta', 'id_producto', 'id_sucursal', 'cant', 'unidad', 'paquete', 'id_promocion'], 'integer'],
            [['precio', 'descuento'], 'number'],
            [['id_venta'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_venta' => 'ID Venta',
            'id_producto' => 'Producto',
            'id_sucursal' => 'Sucursal',
            'cant' => 'Cantidad',
            'precio' => 'Precio',
            'descuento' => 'Descuento',
            'unidad' => 'Unidad',
            'paquete' => 'Paquete',
            'id_promocion' => 'ID Promoción',
        ];
    }
}
