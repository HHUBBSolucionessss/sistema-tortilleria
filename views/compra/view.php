<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use yii\bootstrap\Modal;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = 'Compra Gas LP '. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-view">

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
                  'heading'=>'Registrar compra',
                  'type'=>DetailView::TYPE_INFO,
              ],
              'attributes'=>
              [
                [
                    'attribute'=>'id',
                    'label'=>'Folio',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'id_sucursal',
                    'format'=>'raw',
                    'value'=>$model->obtenerNombreSucursal($model->id_sucursal),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'id_cuenta',
                    'format'=>'raw',
                    'value'=>$model->obtenerCuenta($model->id_cuenta),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'a_pagos',
                    'format'=>'raw',
                    'value'=>$model->obtenerTipoPago($model->a_pagos),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'limite_credito',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'nombre_proveedor',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'limite_credito',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'total_litros',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'precio_litro',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'total',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'estado',
                    'format'=>'raw',
                    'value'=>$model->estado ? '<span class="label label-danger">No pagado</span>' : '<span class="label label-success">Pagado </span>',
                    'type'=>DetailView::INPUT_SWITCH,
                    'widgetOptions' =>
                    [
                        'pluginOptions' =>
                        [
                            'onText' => 'No pagado',
                            'offText' => 'Pagado',
                        ]
                    ],
                ],
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
              ]
          ]);

      ?>
      </div>

</div>
