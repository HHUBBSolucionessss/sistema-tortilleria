<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_cliente') ?>

    <?= $form->field($model, 'id_sucursal') ?>

    <?= $form->field($model, 'id_vendedor') ?>

    <?= $form->field($model, 'cancelada') ?>

    <?php // echo $form->field($model, 'abierta') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'impuesto') ?>

    <?php // echo $form->field($model, 'descuento') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'saldo') ?>

    <?php // echo $form->field($model, 'remision') ?>

    <?php // echo $form->field($model, 'factura') ?>

    <?php // echo $form->field($model, 'folio_factura') ?>

    <?php // echo $form->field($model, 'tipo_pago') ?>

    <?php // echo $form->field($model, 'terminacion_tarjeta') ?>

    <?php // echo $form->field($model, 'terminal_tarjeta') ?>

    <?php // echo $form->field($model, 'cargo_tarjeta') ?>

    <?php // echo $form->field($model, 'folio_deposito') ?>

    <?php // echo $form->field($model, 'a_pagos') ?>

    <?php // echo $form->field($model, 'abonado') ?>

    <?php // echo $form->field($model, 'create_user') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_user') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'cancel_user') ?>

    <?php // echo $form->field($model, 'cancel_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
