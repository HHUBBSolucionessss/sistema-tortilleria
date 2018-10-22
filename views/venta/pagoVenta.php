<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PagoVenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pago-venta-form">
    <?php
        echo "Total: $".$totales[0]['subtotal'];
        echo "<br>Restan: $".$totales[0]['saldo'];
        echo "<br>";
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($pagoVenta, 'ingreso')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Capturar pago', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
