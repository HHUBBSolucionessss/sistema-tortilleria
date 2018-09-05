<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_proveedor')->textInput() ?>

    <?= $form->field($model, 'id_comprador')->textInput() ?>

    <?= $form->field($model, 'id_ctdestino')->textInput() ?>

    <?= $form->field($model, 'id_ctorigen')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_pago')->textInput() ?>

    <?= $form->field($model, 'num_cheque')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'folio_terminal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comision')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'concepto_pago')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remision')->textInput() ?>

    <?= $form->field($model, 'factura')->textInput() ?>

    <?= $form->field($model, 'folio_remision')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'folio_factura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'a_pagos')->textInput() ?>

    <?= $form->field($model, 'abonado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
