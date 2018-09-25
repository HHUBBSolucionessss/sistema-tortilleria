<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Caja;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Caja */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caja-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'efectivo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tipo_movimiento')->widget(Select2::classname(), [
            'data' => ['0'=>'Entrada','1'=>'Salida'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
