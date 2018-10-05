<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "costales".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $costales_ini
 * @property int $costales_fin
 * @property int $id_caja_ini
 * @property int $id_caja_fin
 */
class Costales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'costales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'costales_ini', 'costales_fin', 'id_caja_ini', 'id_caja_fin'], 'required'],
            [['id_sucursal', 'costales_ini', 'costales_fin'], 'integer'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sucursal' => 'Id Sucursal',
            'costales_ini' => 'Cost. Inicio',
            'costales_fin' => 'Cost. Fin',
            'id_caja_ini' => 'Folio Apertura Caja',
            'id_caja_fin' => 'Folio Cierre Caja',
            'usados_dia' => 'Usados',
            'precio_dia' => 'Precio X Costal',
            'create_time' => 'Creado',
        ];
    }
}
