<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="reporte-ganancia">

<?php echo '<h1> Reporte del día '. $fecha_inicio. ' al día '.$fecha_fin.'</h1>' ?>

        <div class="col-md-8">
          <h2><p>Ingresos (+)</p></h2>

          <p>Ventas:  $<?=$ingresos['ventas']?></p>
          <p>Ingresos Caja: $<?=$ingresos['ingresoCaja']?></p>
          <p>Ingresos Boveda: $<?=$ingresos['ingresoBoveda']?></p>
          <p>Ingresos Banco: $<?=$ingresos['ingresoBanco']?></p>
          <p>Ingresos Extras: $<?=$ingresos['ingresoExtra']?></p>

        </div>
        <div class="col-md-4">
          <h3><p>Costal y Utilidad</p></h3>

          <p>Precio Costal: $<?=$costal['precioCostal']?></p>
          <p>Precio Kilo Tortilla: $<?=$costal['precioTortilla']?></p>
          <p>GasLP x Costal: $<?=$costal['precioCostalLP']?></p>
          <p>Utilidad: $<?=$costal['utilidad']?></p>
          <p>Porcentaje de Utilidad <?=$costal['porcentajeUtilidad']?>%</p>

        </div>
        <div class="col-md-6">
          <h2><p>Gastos (-)</p></h2>

          <p>Gastos Caja: $<?=$gastos['gastoCaja']?></p>
          <p>Pago Nominas: $<?=$gastos['pagoNominas']?></p>
          <p>Gastos Banco: $<?=$gastos['gastoBanco']?></p>
          <p>Gastos Gas LP: $<?=$gastos['gastoGas']?></p>
          <p>Gasto Compras: $<?=$gastos['gastoCompras']?></p>

        </div>

</div>
