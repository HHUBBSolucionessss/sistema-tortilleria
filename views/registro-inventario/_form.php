<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\Url;
use app\models\RegistroInventarioDetallado;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroInventario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-inventario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">

    <?php
    $detallado = new RegistroInventarioDetallado;
    ?>

    <?= $form->field($model, 'estado')->textInput() ?>
    </div>

    <div class="col-md-6">

    <?= $form->field($model, 'nota')->textInput(['maxlength' => true]) ?>

  </div>
  <div class="col-md-6">

    <?= $form->field($detallado, 'codigo')->textInput() ?>

    <?= $form->field($detallado, 'id_producto')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    </div>
    <div class="col-md-2">

    <?= $form->field($detallado, 'costo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detallado, 'precio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detallado, 'cantidad_actual')->textInput() ?>

  </div>

    <?php ActiveForm::end(); ?>

</div>
