<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Nueva venta '. $model->id;
?>

<div class="venta-form">

  <div class="col-md-4">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cliente')->textInput() ?>

    <?= $form->field($model, 'id_vendedor')->textInput(['maxlength' => true])?>

  </div>
  <div class="col-md-4">

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true]) ?>

  </div>
  <div class="col-md-4">

    <?= $form->field($model, 'a_pagos')->textInput() ?>

    <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-4">
      <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    </div>
  </div>

        <div class="form-group col-md-offset-6">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

</div>


    <?php ActiveForm::end(); ?>

</div>
