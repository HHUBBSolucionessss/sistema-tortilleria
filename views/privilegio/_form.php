<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Privilegio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="privilegio-form">

    <?php $form = ActiveForm::begin(); ?>

  <p> Caja

    <?= $form->field($model, 'movimientos_caja')->checkbox(array('label'=>'Movimientos de caja')); ?>

    <?= $form->field($model, 'apertura_caja')->checkbox(array('label'=>'Apertura de caja')); ?>

    <?= $form->field($model, 'cierre_caja')->checkbox(array('label'=>'Cierre de caja')); ?>

  </p>
  <p> Clientes

    <?= $form->field($model, 'crear_cliente')->checkbox(array('label'=>'Crear cliente')); ?>

    <?= $form->field($model, 'modificar_cliente')->checkbox(array('label'=>'Modificar cliente')); ?>

    <?= $form->field($model, 'eliminar_cliente')->checkbox(array('label'=>'Eliminar cliente')); ?>

  </p>
  <p> Productos

    <?= $form->field($model, 'crear_producto')->checkbox(array('label'=>'Crear producto')); ?>

    <?= $form->field($model, 'modificar_producto')->checkbox(array('label'=>'Modificar producto')); ?>

    <?= $form->field($model, 'eliminar_producto')->checkbox(array('label'=>'Eliminar producto')); ?>

  </p>
  <p> Ventas

    <?= $form->field($model, 'crear_venta')->checkbox(array('label'=>'Crear venta')); ?>

    <?= $form->field($model, 'pago_venta')->checkbox(array('label'=>'Pago venta')); ?>

    <?= $form->field($model, 'cancelar_venta')->checkbox(array('label'=>'Cancelar venta')); ?>

  </p>
  <p> Nóminas

    <?= $form->field($model, 'crear_nomina')->checkbox(array('label'=>'Crear nómina')); ?>

    <?= $form->field($model, 'cancelar_nomina')->checkbox(array('label'=>'Cancelar nómina')); ?>

  </p>
  <p> Sucursal

    <?= $form->field($model, 'crear_sucursal')->checkbox(array('label'=>'Crear sucursal')); ?>

    <?= $form->field($model, 'modificar_sucursal')->checkbox(array('label'=>'Modificar sucursal')); ?>

    <?= $form->field($model, 'eliminar_sucursal')->checkbox(array('label'=>'Eliminar sucursal')); ?>

  </p>
  <p> Trabajadores

    <?= $form->field($model, 'crear_trabajador')->checkbox(array('label'=>'Crear trabajador')); ?>

    <?= $form->field($model, 'modificar_trabajador')->checkbox(array('label'=>'Modificar trabajador')); ?>

    <?= $form->field($model, 'eliminar_trabajador')->checkbox(array('label'=>'Eliminar trabajador')); ?>

  </p>
  <p> Usuarios

    <?= $form->field($model, 'crear_usuario')->checkbox(array('label'=>'Crear usuario')); ?>

    <?= $form->field($model, 'modificar_usuario')->checkbox(array('label'=>'Modificar usuario')); ?>

    <?= $form->field($model, 'eliminar_usuario')->checkbox(array('label'=>'Eliminar usuario')); ?>

    <?= $form->field($model, 'definir_privilegios')->checkbox(array('label'=>'Asignar privilegios')); ?>

  </p>
  <p> Ver

    <?= $form->field($model, 'ver_banco')->checkbox(array('label'=>'Banco')); ?>

    <?= $form->field($model, 'ver_boveda')->checkbox(array('label'=>'Bóvda')); ?>

    <?= $form->field($model, 'ver_caja')->checkbox(array('label'=>'Caja')); ?>

    <?= $form->field($model, 'ver_cuentas')->checkbox(array('label'=>'Cuentas')); ?>

    <?= $form->field($model, 'ver_clientes')->checkbox(array('label'=>'Clientes')); ?>

    <?= $form->field($model, 'ver_venta')->checkbox(array('label'=>'Venta')); ?>

    <?= $form->field($model, 'ver_productos')->checkbox(array('label'=>'Productos')); ?>

    <?= $form->field($model, 'ver_sucursales')->checkbox(array('label'=>'Sucursales')); ?>

    <?= $form->field($model, 'ver_trabajadores')->checkbox(array('label'=>'Trabajadores')); ?>

    <?= $form->field($model, 'ver_reportes')->checkbox(array('label'=>'Reportes')); ?>

    <?= $form->field($model, 'ver_nominas')->checkbox(array('label'=>'Nóminas')); ?>

    <?= $form->field($model, 'ver_costales')->checkbox(array('label'=>'Costales')); ?>

    <?= $form->field($model, 'ver_registro_sistema')->checkbox(array('label'=>'Registro Sistema')); ?>

    <?= $form->field($model, 'ver_usuarios')->checkbox(array('label'=>'Usuarios')); ?>

  </p>

</div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
