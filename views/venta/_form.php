<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cliente')->textInput() ?>

    <?= $form->field($model, 'id_sucursal')->textInput() ?>

    <?= $form->field($model, 'id_vendedor')->textInput() ?>

    <?= $form->field($model, 'cancelada')->textInput() ?>

    <?= $form->field($model, 'abierta')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'impuesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remision')->textInput() ?>

    <?= $form->field($model, 'factura')->textInput() ?>

    <?= $form->field($model, 'folio_factura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_pago')->textInput() ?>

    <?= $form->field($model, 'terminacion_tarjeta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'terminal_tarjeta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_tarjeta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'folio_deposito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'a_pagos')->textInput() ?>

    <?= $form->field($model, 'abonado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_user')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_user')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'cancel_user')->textInput() ?>

    <?= $form->field($model, 'cancel_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
