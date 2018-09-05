<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-4">
      <?php
      $user= new User();
          echo DetailView::widget([
              'model'=>$model,
              'condensed'=>true,
              'hover'=>true,
              'mode'=>DetailView::MODE_VIEW,
              'deleteOptions'=>[
                'params'=>['id' => $model->id],
                'url'=> ['delete', 'id' => $model->id],
                'data'=> [
                  //'confirm'=>'¿Está seguro que desea eliminar esta habitación?',
                  'method'=>'post',
                ],
              ],
              'panel'=>[
                  'heading'=>'Registrar compra </br>' . $model->id,
                  'type'=>DetailView::TYPE_INFO,
              ],
              'attributes'=>
              [
                [
                    'attribute'=>'id',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                'id_proveedor',
                'id_sucursal',
                'id_comprador',
                'id_ctdestino',
                'id_ctorigen',
                'subtotal',
                'impuesto',
                'descuento',
                'total',
                'tipo_pago',
                'num_cheque',
                'beneficiario',
                'folio_terminal',
                'comision',
                'referencia',
                'concepto_pago',
                'remision',
                'factura',
                'folio_remision',
                'folio_factura',
                'a_pagos',
                'abonado',
                'cancelada',
                'estado',
                  [
                      'attribute'=>'create_user',
                      'format'=>'raw',
                      'value'=>$user->obtenerNombre($model->create_user),
                      'displayOnly'=>true,
                  ],
                  [
                      'attribute'=>'create_time',
                      'format'=>'date',
                      'value'=>$model->create_time,
                      'displayOnly'=>true,
                  ],
                  [
                      'attribute'=>'update_user',
                      'format'=>'raw',
                      'displayOnly'=>true,
                  ],
                  [
                      'attribute'=>'update_time',
                      'format'=>'raw',
                      'displayOnly'=>true,
                  ],
              ]
          ]);

      ?>
      </div>

</div>
