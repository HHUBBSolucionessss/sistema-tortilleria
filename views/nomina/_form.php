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
  function calcularSueldo()
  {

    var sueldoBase =parseFloat($("_sueldoBase").val());
    var diasTrabajados=$("_dias_trabajados").val();
    var descuentos =parseFloat($("_descuentos").val());
    var bonos =parseFloat($("_bonos").val());
    var sueldoDiario, num2;
    var total;
    var subtotal;

    sueldoDiario = (sueldoBase / 7) * (diasTrabajados);
    subTotal = parseFloat(sueldoDiario);

    total=(subTotal + bonos) - (descuentos);

    $("#_sueldo").val(subTotal);
    $("#_total").val(total);
  }

    $(document).on('change', '#_trabajador', function()
    {
          $.ajax
          ({
              data: {"id_trabajador":$("#_trabajador").prop('selectedIndex')},
              type: "POST",
              dataType: "text",
              url:"<?php echo \yii\helpers\Url::to(['nomina/obtener-sueldo'])?>",
          })
          .done(function( data, textStatus, jqXHR )
          {
              $("#_sueldoBase").val(data);

          })
          .fail(function( jqXHR, textStatus, errorThrown ) 
          {
              if ( console && console.log ) 
                console.log( "La solicitud a fallado: " +  textStatus);
          });
    });

</script>


    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">
    <div class="col-md-4">
      <?= $form->field($model, 'id_trabajador')->dropDownList(
        ArrayHelper::map(Trabajador::find()->all(), 'id', 'nombre'),
        [
          'prompt' => 'Seleccione Un trabajador',
          'id'=>'_trabajador',
          'onchange'=>
          '
              $.ajax
              ({
                  data: {"id_trabajador":$("#_trabajador").prop("selectedIndex")},
                  type: "POST",
                  dataType: "text",
                  url:"<?php echo \yii\helpers\Url::to(["nomina/obtener-sueldo"])?>",
              })
              .done(function( data, textStatus, jqXHR )
              {
                  $("#_sueldoBase").val(data);

              })
              .fail(function( jqXHR, textStatus, errorThrown ) 
              {
                  if ( console && console.log ) 
                    console.log( "La solicitud a fallado: " +  textStatus);
              });
            });

          '
        ]);
     ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'sueldo_base')->textInput(['id'=>'_sueldoBase', 'readOnly' => true]) ?>
  </div>
  <div class="col-md-4">
  <?= $form->field($model, 'dias_trabajados')->textInput(['id'=>'_dias_trabajados', 'onchange' => 'calcularSueldo();']) ?>
</div>
</div>

  <div class="col-md-12">
    <div class="col-md-3">
    <?= $form->field($model, 'descuentos')->textInput(['id'=>'_descuentos', 'maxlength' => true, 'onchange' => 'calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'bonos')->textInput(['id'=>'_bonos', 'maxlength' => true, 'onchange' => 'calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'sueldo')->textInput(['id'=>'_sueldo', 'value' => '0.00', 'onchange' => 'calcularSueldo()']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'total')->textInput(['id'=>'_total', 'value' => '0.00', 'onchange' => 'calcularSueldo()']) ?>
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
