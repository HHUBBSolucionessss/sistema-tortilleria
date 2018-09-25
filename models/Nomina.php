<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nomina".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property int $id_trabajador
 * @property string $sueldo_base
 * @property string $descuentos
 * @property string $sueldo
 * @property string $bonos
 * @property string $notas
 * @property int $dias_trabajados
 * @property int $eliminado
 * @property int $create_user
 * @property string $create_time
 */
class Nomina extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomina';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal', 'id_trabajador', 'create_user', 'sueldo_base', 'sueldo', 'dias_trabajados', 'total'], 'required'],
            [['id_sucursal', 'id_trabajador', 'dias_trabajados', 'eliminado', 'create_user'], 'integer'],
            [['sueldo_base', 'descuentos', 'sueldo', 'bonos','total',], 'number'],
            [['create_time'], 'safe'],
            [['notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Folio',
            'id_sucursal' => 'Sucursal',
            'id_trabajador' => 'Nombre Trabajador',
            'sueldo_base' => 'Sueldo Base',
            'descuentos' => 'Descuento',
            'sueldo' => 'Sub Total',
            'bonos' => 'Bonos',
            'total' => 'Total',
            'notas' => 'Notas',
            'dias_trabajados' => 'Días Trabajados',
            'eliminado' => 'Eliminado',
            'create_user' => 'Registró',
            'create_time' => 'Registrado',
        ];
    }

    public function obtenerNombreTrabajador($id)
    {
      $model = Trabajador::find()
      ->where(['id'=>$id])
      ->one();

      return $model->nombre;
    }

}
