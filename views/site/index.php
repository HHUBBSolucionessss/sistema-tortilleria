<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Tortillería Los Cuates';
?>

<div class="site-index">
    <div class="jumbotron">
        <?= Html::a('Caja', ['/caja/index'], ['class'=>'btn']) ?>
        <?= Html::a('Clientes', ['/cliente/index'], ['class'=>'btn']) ?>
        <?= Html::a('Inventario', ['/inventario/index'], ['class'=>'btn']) ?>
        <?= Html::a('Registro Inventario', ['/registro-inventario/index'], ['class'=>'btn']) ?>
        <?= Html::a('Venta', ['/venta/index'], ['class'=>'btn']) ?>
        <?= Html::a('Productos', ['/producto/index'], ['class'=>'btn']) ?>
        <?= Html::a('Sucursal', ['/sucursal/index'], ['class'=>'btn']) ?>
        <?= Html::a('Trabajadores', ['/trabajador/index'], ['class'=>'btn']) ?>
        <?php
        //if($privilegio[0]['ver_registro_sistema'] == 1)
        echo Html::a('Registro Sistema', ['site/registro'], ['class'=>'btn']) ?>
        <?= Html::a('Usuarios', ['/registrar-usuario/index'], ['class'=>'btn']) ?>

    </div>
  </div>
