<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\PagoVenta */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Pago Venta';

?>

<script type="text/javascript">

    function pagoVenta()
    {

      var enviar = document.getElementById('_submit');

      if($("#_ingreso").val() < <?php echo $totales[0]['subtotal']; ?> || $("#_ingreso").val() > <?php echo $totales[0]['subtotal']; ?>)
      {
        alert("La cantidad debe ser igual al subtotal");
        enviar.disabled = true;
      }
      else{
        enviar.disabled = false;
      }
    }
</script>

<div class="pago-venta-form">
  <div class="col-sm-4">
    <h2><?php echo "Sub Total: $".$totales[0]['subtotal'];?></h2>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($pagoVenta, 'ingreso')->textInput(['id' => '_ingreso', 'maxlength' => true, 'onchange'=>"pagoVenta()"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Capturar pago', ['id' => '_submit', 'class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
