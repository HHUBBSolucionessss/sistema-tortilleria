<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use yii\bootstrap\Modal;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = 'Devolución '. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Devoluciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-view">

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
                  'heading'=>'Devolución ' . $model->id,
                  'type'=>DetailView::TYPE_INFO,
              ],
              'attributes'=>
              [
                [
                    'attribute'=>'id',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'id_cliente',
                    'format'=>'raw',
                    'value'=>$model->obtenerNombreCliente($model->id_cliente),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'id_vendedor',
                    'format'=>'raw',
                    'value'=>$model->obtenerNombreTrabajador($model->id_vendedor),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'id_sucursal',
                    'format'=>'raw',
                    'value'=>$model->obtenerNombreSucursal($model->id_sucursal),
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'subtotal',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'total',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                [
                    'attribute'=>'notas',
                    'format'=>'raw',
                    'displayOnly'=>true,
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
