<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */
$js = 'jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-precio").each(function(index) {
        jQuery(this).html("Precio: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-precio").each(function(index) {
        jQuery(this).html("Precio: " + (index + 1))
    });
});
';
$this->registerJs($js);
?>

<div class="venta-form">

  <div class="col-md-4">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cliente')->textInput() ?>

    <?php
        $url = \yii\helpers\Url::to(['venta']);
        echo $form->field($model, 'id_vendedor')->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Buscar trabajador ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Esperando resultados...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(nombre) { return nombre.text; }'),
            'templateSelection' => new JsExpression('function (nombre) { return nombre.text; }'),
        ],
    ]);?>

  </div>
  <div class="col-md-4">

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descuento')->textInput(['maxlength' => true]) ?>

  </div>
  <div class="col-md-4">

    <?= $form->field($model, 'a_pagos')->textInput() ?>

    <?= $form->field($model, 'saldo')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-4">
      <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    </div>
  </div>

    <div class="row col-md-10 col-md-offset-1">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 10, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $modelVentaDetallada[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'id_producto',
                'cant',
                'precio',
                'descuento',
                'unidad',
                'paquete',
            ],

        ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-envelope"></i> Venta
                <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i>Agregar Producto</button>
                <div class="clearfix"></div>
            </div>
            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelVentaDetallada as $index => $modeldetallada): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-precio">Producto: <?= ($index + 1) ?></span>
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i>Eliminar Producto</i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (!$modeldetallada->isNewRecord) {echo Html::activeHiddenInput($modeldetallada, "[{$index}]id");}
                            ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]id_producto")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]cant")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]precio")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]descuento")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]unidad")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modeldetallada, "[{$index}]paquete")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div><!-- end:row -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <div class="form-group col-md-offset-6">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        </div>
</div>


    <?php ActiveForm::end(); ?>

</div>
