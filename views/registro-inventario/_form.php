<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\RegistroInventarioDetallado;
use app\models\Producto;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroInventario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-inventario-form">

  <?php $form = ActiveForm::begin(); ?>

  <?php
  $detallado = new RegistroInventarioDetallado;
  ?>

  <div class="col-md-12">
    <div class="col-md-4">
      <?= $form->field($detallado, 'id_producto')->widget(Select2::classname(), [
         'data' => ArrayHelper::map(Producto::find()->all(), 'id', 'nombre'),
         'value'=>1,
         'options' => ['placeholder' => 'Selecciona un producto...', 'select'=>'0'],
         'pluginOptions' => [
             'allowClear' => true
         ],
     ]);
     ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($detallado, 'codigo')->textInput(['readOnly'=>false]) ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($detallado, 'precio')->textInput(['readOnly'=>false]) ?>
    </div>
  </div>
  <div class="col-md-12">
    <div class="col-md-3">
      <?= $form->field($detallado, 'cantidad_anterior')->textInput(['readOnly'=>false]) ?>
    </div>
    <div class="col-md-3">
      <?= $form->field($detallado, 'cantidad_actual')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'nota')->textArea(['maxlength' => true]) ?>
    </div>
  </div>

  <div class="form-group">
      <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
