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
    <p>Efectivo: $ <?=$totalCaja[0]['Sum(efectivo)']?></p>
    <p>Tarjeta: $ <?=$totalCaja[0]['Sum(tarjeta)']?></p>
    <p>Depósito: $ <?=$totalCaja[0]['Sum(deposito)']?></p>

    <?= $form->field($model, 'efectivo')->Input(['autofocus' => true], ['placeholder' => "Efectivo a ingresar"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Abrir Caja', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
