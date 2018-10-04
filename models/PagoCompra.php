<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pago_compra".
 *
 * @property int $id
 * @property int $id_compra
 * @property int $ingreso
 */
class PagoCompra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pago_compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ingreso', 'create_user','id_cuenta'], 'required'],
            [['ingreso', 'create_user'], 'integer'],
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
            'ingreso' => 'Ingreso',
            'id_cuenta' => 'Cuenta',
            'create_user' => 'Registró',
            'create_time' => 'Creado',
        ];
    }
}
