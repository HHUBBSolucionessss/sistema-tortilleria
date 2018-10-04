<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Cuenta;
use app\models\Sucursal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">

  function calcularTotal()
  {
    var totalLitros=parseFloat($("#_totalLitros").val());
    var precioLitro=parseFloat($("#_precioLitro").val());
    var total;

    total = totalLitros * precioLitro;

    $("#_total").val(total);

  };

</script>

<div class="compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cuenta')->widget(Select2::classname(), [
         'data' => ArrayHelper::map(Cuenta::find()->where(['eliminado' => 0])->all(), 'id', 'nombre'),
         'value'=>1,
         'options' => ['placeholder' => 'Selecciona una cuenta...', 'select'=>'0'],
         'pluginOptions' => [
             'allowClear' => true
         ],
     ]);
     ?>


    <?= $form->field($model, 'limite_credito')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre_proveedor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_litros')->textInput(['id' => '_totalLitros', 'value' => 0, 'onchange'=>"calcularTotal()"]) ?>

    <?= $form->field($model, 'precio_litro')->textInput(['id' => '_precioLitro', 'value' => '0.00', 'onchange'=>"calcularTotal()"]) ?>

    <?= $form->field($model, 'total')->textInput(['id' => '_total', 'value' => '0.00', 'readOnly' => true, 'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['id' => '_submit', 'class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
