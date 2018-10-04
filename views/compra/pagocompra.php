<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Cuenta;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PagoVenta */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">

  function pagoCompra()
  {
      var enviar = document.getElementById('_submit');

      if($("#_ingreso").val() < <?php echo $compra; ?> || $("#_ingreso").val() > <?php echo $compra; ?>)
      {
        alert("La cantidad debe ser igual al total");
        enviar.disabled = true;
      }
      else{
        enviar.disabled = false;
      }
  };

</script>

<div class="pago-compra-form">
    <?php
        echo "Total: $".$compra;
        echo "<br><br>";
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($pagoCompra, 'ingreso')->textInput(['id' => '_ingreso', 'maxlength' => true, 'onchange'=>"pagoCompra()"]) ?>

    <?= $form->field($pagoCompra, 'id_cuenta')->widget(Select2::classname(), [
         'data' => ArrayHelper::map(Cuenta::find()->where(['eliminado' => 0])->all(), 'id', 'nombre'),
         'value'=>1,
         'options' => ['placeholder' => 'Selecciona una cuenta...', 'select'=>'0'],
         'pluginOptions' => [
             'allowClear' => true
         ],
     ]);
     ?>

    <div class="form-group">
        <?= Html::submitButton('Capturar pago', ['id' => '_submit', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
