<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trabajador".
 *
 * @property int $id
 * @property int $sucursal_id
 * @property string $nombre
 * @property string $apellidos
 * @property int $puesto
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property string $direccion
 * @property string $ciudad
 * @property string $estado
 * @property int $cp
 * @property string $sueldo
 * @property int $nomina
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property resource $imagen
 * @property resource $huella
 * @property int $eliminado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 * @property int $delete_user
 * @property string $delete_time
 */
class Trabajador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trabajador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sucursal_id', 'puesto'], 'required'],
            [['sucursal_id', 'puesto', 'cp', 'nomina', 'eliminado', 'create_user', 'update_user', 'delete_user'], 'integer'],
            [['sueldo'], 'number'],
            [['fecha_inicio', 'fecha_fin', 'create_time', 'update_time', 'delete_time'], 'safe'],
            [['imagen', 'huella'], 'string'],
            [['nombre', 'apellidos', 'telefono', 'celular', 'email', 'direccion', 'ciudad', 'estado'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sucursal_id' => 'Sucursal ID',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'puesto' => 'Puesto',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'email' => 'Email',
            'direccion' => 'Direccion',
            'ciudad' => 'Ciudad',
            'estado' => 'Estado',
            'cp' => 'Cp',
            'sueldo' => 'Sueldo',
            'nomina' => 'Nomina',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'imagen' => 'Imagen',
            'huella' => 'Huella',
            'eliminado' => 'Eliminado',
            'create_user' => 'Create User',
            'create_time' => 'Create Time',
            'update_user' => 'Update User',
            'update_time' => 'Update Time',
            'delete_user' => 'Delete User',
            'delete_time' => 'Delete Time',
        ];
    }
}
