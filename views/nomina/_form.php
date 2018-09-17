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

        $(document).on('click', '#_btnSaldo', function()
          {
            $('#_sueldoBase').val("1200");
          });

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
    <?= $form->field($model, 'sueldo_base')->textInput(['id'=>'_sueldoBase', 'maxlength' => true, 'readOnly' => true]) ?>
  </div>
  <div class="col-md-2">
  <?= $form->field($model, 'dias_trabajados')->textInput() ?>
</div>
<div class="col-md-2">
    <button type="button" class="btn btn-large btn-success" id="_btnSaldo">Buscar sueldo</button>
</div>
</div>

  <div class="col-md-12">
    <div class="col-md-4">
    <?= $form->field($model, 'descuentos')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-md-4">
    <?= $form->field($model, 'sueldo')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-md-4">
    <?= $form->field($model, 'bonos')->textInput(['maxlength' => true]) ?>
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
