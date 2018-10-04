<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Tortillería Los Cuates';
?>

<h1>
  <?php
    echo "Sucursal ". $sucursal[0]['nombre'];
  ?>
</h1>

<div class="site-index">
    <div class="jumbotron">

      <?php
      if($privilegio[0]['ver_banco'] == 1)
      echo Html::a('Banco', ['/banco/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_boveda'] == 1)
      echo Html::a('Bóveda', ['/boveda/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_caja'] == 1)
      echo Html::a('Caja', ['/caja/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_cuentas'] == 1)
      echo Html::a('Cuenta', ['/cuenta/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_clientes'] == 1)
      echo Html::a('Clientes', ['/cliente/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_venta'] == 1)
      echo Html::a('Venta', ['/venta/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_devoluciones'] == 1)
      echo Html::a('Devoluciones', ['/devoluciones/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_productos'] == 1)
      echo Html::a('Productos', ['/producto/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_sucursales'] == 1)
      echo Html::a('Sucursal', ['/sucursal/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_trabajadores'] == 1)
      echo Html::a('Trabajadores', ['/trabajador/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_reportes'] == 1)
      echo Html::a('Reportes', ['/reportes/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_nominas'] == 1)
      echo Html::a('Nóminas', ['/nomina/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_compra'] == 1)
      echo Html::a('Compras', ['/compra/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_costales'] == 1)
      echo Html::a('Costales', ['/costales/index'], ['class'=>'btn']);

      if($privilegio[0]['ver_registro_sistema'] == 1)
      echo Html::a('Registro Sistema', ['site/registro'], ['class'=>'btn']);

      if($privilegio[0]['ver_usuarios'] == 1)
      echo Html::a('Usuarios', ['/registrar-usuario/index'], ['class'=>'btn']);


        ?>
    </div>
  </div>
