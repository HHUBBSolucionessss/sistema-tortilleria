<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Cliente;
use app\models\Producto;
use app\models\Trabajador;
use yii\web\JsExpression;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Nueva venta '. $modelVenta->id;

$js ='
    jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item)
    {
        jQuery(".dynamicform_wrapper .panel-title-precio").each(function(index)
        {
            jQuery(this).html("Precio: " + (index + 1));
        });
    });

    jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
        jQuery(".dynamicform_wrapper .panel-title-precio").each(function(index)
        {
            jQuery(this).html("Precio: " + (index + 1))
        });
    });
';
$this->registerJs($js);
?>
<script type="text/javascript">

    function calcularSubTotal()
    {
        var subtotal=0;
            jQuery(".dynamicform_wrapper .panel-title-precio").each(function(index)
            {
                if ($("#ventadetallada-"+index+"-precio").val()!='' && $("#ventadetallada-"+index+"-cant").val()!='')
                {
                    var precio=$("#ventadetallada-"+index+"-precio").val();
                    var cantidad=$("#ventadetallada-"+index+"-cant").val();
                    subtotal+=parseFloat(precio)*parseFloat(cantidad);
                    $("#_subtotal").val(subtotal);
                    calcularTotal();

                }

            });
    };
    function calcularTotal()
    {
        var subtotal=parseFloat($("#_subtotal").val());
        var descuento=parseFloat($("#_descuento").val());
        $("#_total").val(subtotal-descuento);
    };

</script>
<h1><?= Html::encode($this->title) ?></h1>
  <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <div class="col-sm-7">
    <div class="row">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $ventaProducto[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'id_producto',
                    'cant',
                    'precio',
                ],

            ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-envelope"></i> Producto
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Agregar Producto</button>
                    <div class="clearfix"></div>
                </div>
                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($ventaProducto as $index => $modeldetallada): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-precio">Producto: <?= ($index + 1) ?></span>
                                <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    // necessary for update action.
                                    if (!$modeldetallada->isNewRecord) {echo Html::activeHiddenInput($modeldetallada, "[{$index}]id");}
                                ?>
                                <div class="row">
                                  <div class="col-sm-6">
                                      <?=$form->field($modeldetallada, "[{$index}]id_producto")->dropDownList(
                                            ArrayHelper::map(Producto::find()->all(), 'id', 'nombre')
                                            );
                                    ?>
                                  </div>
                                    <div class="col-sm-2">
                                        <?= $form->field($modeldetallada, "[{$index}]precio")->textInput(['maxlength' => true, 'onchange'=>"calcularSubTotal()"]) ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <?= $form->field($modeldetallada, "[{$index}]cant")->textInput(['maxlength' => true, 'onchange'=>"calcularSubTotal()"]) ?>
                                    </div>
                                </div><!-- end:row -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
    </div>
  </div>

    <div class="row">
        <div class="col-md-4">
          <?= $form->field($modelVenta, 'id_cliente')->widget(Select2::classname(), [
             'data' => ArrayHelper::map(Cliente::find()->where(['eliminado' => 0 ])->all(), 'id', 'nombre'),
             'value'=>1,
             'options' => ['placeholder' => 'Selecciona un cliente ...', 'select'=>'0'],
             'pluginOptions' => [
                 'allowClear' => true
             ],
         ]);
         ?>
        </div>
        <div class="col-md-4">
             <?= $form->field($modelVenta, 'id_vendedor')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Trabajador::find()->where(['eliminado' => 0 ])->all(), 'id', 'nombre'),
                'value'=>1,
                'options' => ['placeholder' => 'Selecciona un trabajador ...', 'select'=>'0'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($modelVenta, 'subtotal')->textInput(['readOnly' => true, 'maxlength' => true,'id'=>'_subtotal', 'onchange'=>"calcularTotal()"]) ?>

            <?= $form->field($modelVenta, 'descuento')->textInput(['maxlength' => true, 'value' => 0,'id'=>'_descuento' ,'onchange'=>"calcularTotal()"]) ?>

            <?= $form->field($modelVenta, 'total')->textInput(['readOnly' => true, 'maxlength' => true,'id'=>'_total']) ?>

            <?= $form->field($modelVenta, 'a_pagos')->checkbox(array(
              'label'=>'A crédito',
            ));
            ?>

            <div class="form-group">
                <?= Html::submitButton($modeldetallada->isNewRecord ? 'Guardar' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>

      </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
