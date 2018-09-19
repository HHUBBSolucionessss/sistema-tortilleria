<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property int $sucursal_id
 * @property string $nombre
 * @property string $rfc
 * @property string $calle
 * @property string $num_ext
 * @property string $num_int
 * @property string $colonia
 * @property string $ciudad
 * @property string $estado
 * @property string $cp
 * @property string $telefono1
 * @property string $lada1
 * @property string $lada2
 * @property string $limite_credito
 * @property int $eliminado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 * @property int $delete_user
 * @property string $delete_time
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sucursal_id'], 'required'],
            [['sucursal_id', 'eliminado', 'create_user', 'update_user', 'delete_user'], 'integer'],
            [['limite_credito'], 'number'],
            [['create_time', 'update_time', 'delete_time'], 'safe'],
            [['nombre','calle', 'colonia', 'ciudad', 'estado', 'telefono1',], 'string', 'max' => 45],
            [['cp'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sucursal_id' => 'Sucursal',
            'nombre' => 'Nombre',
            'calle' => 'Calle',
            'colonia' => 'Colonia',
            'ciudad' => 'Ciudad',
            'estado' => 'Estado',
            'cp' => 'Código Postal',
            'telefono1' => 'Teléfono',
            'limite_credito' => 'Límite de Crédito',
            'eliminado' => 'Eliminado',
            'create_user' => 'Registró',
            'create_time' => 'Creado',
            'update_user' => 'Actualizó',
            'update_time' => 'Actualizado a las',
            'delete_user' => 'Delete User',
            'delete_time' => 'Delete Time',
        ];
    }
}
