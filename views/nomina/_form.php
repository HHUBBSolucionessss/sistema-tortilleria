<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Trabajador;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Nomina */
/* @var $form yii\widgets\ActiveForm */
?>

<b>Total en caja: </b><?php echo $model->totalCaja[0]['efectivo'];?>
<br></br>

<div class="nomina-form">

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script type="text/javascript">
  function calcularSueldo()
  {
    var sueldoDiario=0;
    var total=0;
    var subtotal=0;
    sueldoDiario =parseFloat($("#_sueldoBase").val()) / 7;
    subTotal =sueldoDiario.toFixed(2) * parseInt($("#_dias_trabajados").val());
    $("#_sueldo").val(parseFloat(subTotal));
    $("#_total").val(parseFloat(subTotal));
    calcularTotal();
  }

  function totalCaja(){
    var enviar = document.getElementById('_submit');

    if($("#_total").val() < <?php echo $model->totalCaja[0]['efectivo']; ?> || $("#_ingreso").val() > <?php echo $model->totalCaja[0]['efectivo']; ?>)
    {
      enviar.disabled = false;
    }
    else{
      alert("El total sobrepasa el efectivo disponible en caja.");
      enviar.disabled = true;
    }
  }

  function calcularTotal()
  {
    var total=0;

    total=parseFloat($("#_sueldo").val())  + parseFloat($("#_bono").val()) - parseFloat($("#_descuento").val());

      $("#_total").val(total.toFixed(2));
      totalCaja();
  }

  $(document).on('click', '#_btnSueldo', function()
  {
      $.ajax({
          data: {"id_trabajador" : $("#_trabajador").prop("selectedIndex") },
          type: "POST",
          dataType: "json",
          url: "<?php echo \yii\helpers\Url::to(['nomina/obtener-sueldo'])?>",
      })
      .done(function( data, textStatus, jqXHR )
      {
        $("#_sueldoBase").val(data);
        calcularSueldo();

      })
      .fail(function( jqXHR, textStatus, errorThrown ) {
          if ( console && console.log ) {
              console.log( "La solicitud a fallado: " +  textStatus);
          }
      });
  });

</script>

    <?php
      $form = ActiveForm::begin();
      Pjax::begin();
    ?>
    <div class="col-md-12">
    <div class="col-md-4">
      <?= $form->field($model, 'id_trabajador')->dropDownList(
        ArrayHelper::map(Trabajador::find()->where(['eliminado' => 0 ])->all(), 'id', 'nombre'),
        [
          'prompt' => 'Seleccione un trabajador',
          'id'=>'_trabajador',
        ]);
     ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'sueldo_base')->textInput(['id'=>'_sueldoBase', 'readOnly' => true]) ?>
      <button type="button" class="btn btn-large btn-success" id="_btnSueldo">Obtener Sueldo </button>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'dias_trabajados')->textInput(['value' => '7','id'=>'_dias_trabajados', 'onchange' => 'calcularSueldo();']) ?>
    </div>
</div>

  <div class="col-md-12">
    <div class="col-md-3">
    <?= $form->field($model, 'sueldo')->textInput(['readOnly'=>true,'id'=>'_sueldo']) ?>
  </div>
    <div class="col-md-3">
    <?= $form->field($model, 'descuentos')->textInput(['id'=>'_descuento', 'value' => '0.00','maxlength' => true, 'onchange' => 'calcularTotal();']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'bonos')->textInput(['id'=>'_bono', 'value' => '0.00','maxlength' => true, 'onchange' => 'calcularTotal();']) ?>
  </div>
  <div class="col-md-3">
    <?= $form->field($model, 'total')->textInput(['id' => '_total', 'readOnly'=>true]) ?>
  </div>
</div>

  <div class="col-md-12">
    <div class="col-md-6">

    <?= $form->field($model, 'notas')->textArea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['id' => '_submit', 'class' => 'btn btn-success']) ?>
    </div>
  </div>

  </div>

    <?php
      Pjax::end();
      ActiveForm::end();
    ?>

</div>
