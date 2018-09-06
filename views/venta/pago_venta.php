<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

use app\models\Reservacion;

/* @var $this yii\web\View */
/* @var $model app\models\Reservacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="huesped-form">
  <h1><?= Html::encode($this->title) ?></h1>
      <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <?php
        echo "Total: $".$totales[0]['total'];
        echo "<br>Restan: $".$totales[0]['saldo'];
        echo "<br>";
         ?>
        <?= $form->field($model, 'ingreso')->textInput(['maxlength' => true,'id'=>'_ingreso']) ?>
      </div>
    <div class="form-group col-md-offset-10">
        <?= Html::submitButton('Capturar Pago', ['class' => 'btn btn-success','id'=>'_submit']) ?>
    </div>
  <?php ActiveForm::end(); ?>
</div>
