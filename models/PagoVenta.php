<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pago_venta".
 *
 * @property int $id
 * @property int $id_venta
 * @property string $ingreso
 * @property int $create_user
 * @property string $create_time
 */
class PagoVenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pago_venta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_venta', 'create_user', 'ingreso'], 'required'],
            [['id_venta', 'create_user'], 'integer'],
            [['ingreso'], 'number'],
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
            'id_venta' => 'ID Venta',
            'ingreso' => 'Ingreso',
            'create_user' => 'Realizó',
            'create_time' => 'Realizado a las',
        ];
    }
}
