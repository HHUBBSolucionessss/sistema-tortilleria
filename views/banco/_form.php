<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Cuenta;
use app\models\Banco;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Banco */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banco-form">
<script type="text/javascript">
    function cambiarDescripcionMaterial()
    {

        if($("#_compraMaterial").prop("checked"))
        {
            $("#_descripcion").val("COMPRA MATERIAL");

            $("#_descripcion").prop("readonly", true);
             $("#_descripcion").prop("visible", true);
        }
        else
        {
            $("#_descripcion").val("");
            $("#_descripcion").prop("readonly", false);
             $("#_descripcion").prop("visible", false);
        }
    }
</script>

  <?php $form = ActiveForm::begin(); ?>
    <label class="checkbox-inline"><input type="checkbox" id="_compraMaterial" onchange="cambiarDescripcionMaterial()">Compra Material</label>
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'id'=>'_descripcion','visible'=>false]) ?>

    <?= $form->field($model, 'id_cuenta')->widget(Select2::classname(), [
         'data' => ArrayHelper::map(Cuenta::find()->where(['id_sucursal' => $model->id_sucursal])->all(), 'id', 'nombre'),
         'value'=>1,
         'options' => ['placeholder' => 'Selecciona una cuenta...', 'select'=>'0'],
         'pluginOptions' => [
             'allowClear' => true
         ],
     ]);
     ?>
  <?= $form->field($model, 'tipo_movimiento')->widget(Select2::classname(), [
          'data' => ['0'=>'Entrada','1'=>'Salida'],
          'options' => ['placeholder' => 'Selecciona un tipo de movimiento ...', 'select'=>'0'],
          'pluginOptions' => [
              'allowClear' => true
          ],
      ]);
      ?>

  <?= $form->field($model, 'deposito')->textInput(['maxlength' => true]) ?>

  <div class="form-group">
      <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
