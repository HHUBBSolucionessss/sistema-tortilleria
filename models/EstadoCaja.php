<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado_caja".
 *
 * @property int $id
 * @property int $estado_caja
 */
class EstadoCaja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estado_caja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'estado_caja'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado_caja' => 'Estado Caja',
        ];
    }
}
