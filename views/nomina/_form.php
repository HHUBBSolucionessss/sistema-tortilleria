<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Trabajador;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Nomina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomina-form">

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
        <script type="text/javascript">

        function calcularSueldo(){

          var sueldoBase =document.getElementById("_sueldoBase").value;
          var diasTrabajados =document.getElementById("_dias_trabajados").value;
          var descuentos =document.getElementById("_descuentos").value;
          var bonos =document.getElementById("_bonos").value;
          var totalp =document.getElementById("_total").value;
          var num, num2;

          num = (sueldoBase / 7) * (diasTrabajados);
          var subTotal = num.toFixed(2);

          num2 = (subTotal + bonos) - (descuentos);
          total = totalp + bonos;
          var total = num2.toFixed(2);

          $("#_sueldo").val(subTotal);
          $("#_total").val(total);

        }

        </script>


    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">
    <div class="col-md-4">
      <?= $form->field($model, 'id_trabajador')->widget(Select2::classname(), [
         'data' => ArrayHelper::map(Trabajador::find()->all(), 'id', 'nombre'),
         'value'=>1,
         'options' => ['placeholder' => 'Selecciona un trabajador ...', 'select'=>'0'],
         'pluginOptions' => [
             'allowClear' => true
         ],
     ]);
     ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'sueldo_base')->textInput(['id'=>'_sueldoBase', 'readOnly' => false, 'onchange' => 'calcularSueldo()']) ?>
  </div>
  <div class="col-md-4">
  <?= $form->field($model, 'dias_trabajados')->textInput(['id'=>'_dias_trabajados', 'onchange' => 'js:calcularSueldo();']) ?>
</div>
</div>

  <div class="col-md-12">
    <div class="col-md-3">
    <?= $form->field($model, 'descuentos')->textInput(['id'=>'_descuentos', 'maxlength' => true, 'onchange' => 'js:calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'bonos')->textInput(['id'=>'_bonos', 'maxlength' => true, 'onchange' => 'js:calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'sueldo')->textInput(['id'=>'_sueldo', 'value' => '0.00', 'onchange' => 'js:calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'total')->textInput(['id'=>'_total', 'value' => '0.00', 'onchange' => 'js:calcularSueldo()']) ?>
  </div>
</div>

  <div class="col-md-12">
    <div class="col-md-6">

    <?= $form->field($model, 'notas')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>
  </div>

  </div>

    <?php ActiveForm::end(); ?>

</div>
