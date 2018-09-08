<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursal".
 *
 * @property int $id
 * @property string $nombre
 * @property string $calle
 * @property int $numero_ext
 * @property int $numero_int
 * @property int $cp
 * @property string $colonia
 * @property string $estado
 * @property string $ciudad
 * @property string $telefono1
 * @property string $telefono2
 * @property string $fax
 * @property string $email
 * @property resource $logotipo
 * @property string $web
 * @property string $rfc
 * @property int $asignada
 * @property int $eliminado
 * @property int $create_user
 * @property string $create_time
 * @property int $update_user
 * @property string $update_time
 */
class Sucursal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sucursal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['colonia'], 'required'],
            [['numero_ext', 'numero_int', 'cp', 'asignada', 'eliminado', 'create_user', 'update_user'], 'integer'],
            [['logotipo'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['nombre', 'calle', 'estado', 'ciudad', 'telefono1', 'telefono2', 'fax', 'email', 'web', 'rfc'], 'string', 'max' => 45],
            [['colonia'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'calle' => 'Calle',
            'numero_ext' => 'Número Exterior',
            'numero_int' => 'Número Interior',
            'cp' => 'Código Postal',
            'colonia' => 'Colonia',
            'estado' => 'Estado',
            'ciudad' => 'Ciudad',
            'telefono1' => 'Teléfono 1',
            'telefono2' => 'Teléfono 2',
            'fax' => 'Fax',
            'email' => 'Email',
            'logotipo' => 'Logotipo',
            'web' => 'Web',
            'rfc' => 'RFC',
            'asignada' => 'Asignada',
            'eliminado' => 'Eliminado',
            'create_user' => 'Registró',
            'create_time' => 'Create Creado a las',
            'update_user' => 'Actualizó',
            'update_time' => 'Actualizado a las',
        ];
    }

}
