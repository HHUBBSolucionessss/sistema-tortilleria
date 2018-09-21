<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuenta".
 *
 * @property int $id
 * @property string $nombre
 * @property int $num_cuenta
 * @property int $clabe
 */
class Cuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'num_cuenta', 'clabe'], 'required'],
            [['num_cuenta', 'clabe'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
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
            'num_cuenta' => 'Núm. Cuenta',
            'clabe' => 'CLABE',
        ];
    }
}
