<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registro_sistema".
 *
 * @property int $id
 * @property int $id_sucursal
 * @property string $descripcion
 * @property string $create_time
 */
class RegistroSistema extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_sistema';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sucursal'], 'required'],
            [['id_sucursal'], 'integer'],
            [['create_time'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
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
            'descripcion' => 'Descripcion',
            'create_time' => 'Create Time',
        ];
    }
}
