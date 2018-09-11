<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use app\models\VentaSearch;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */

$this->title = 'Cliente '. $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-view">

<h1><?= Html::encode($this->title) ?></h1>
<div class="col-md-12">
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
                'heading'=>'Registrar Usuario </br>' . $model->nombre,
                'type'=>DetailView::TYPE_INFO,
            ],
            'attributes'=>
            [
              [
                  'attribute'=>'id',
                  'format'=>'raw',
                  'displayOnly'=>true,
              ],
              'nombre',
              'calle',
              'colonia',
              'ciudad',
              'estado',
              'cp',
              'telefono1',
              'limite_credito',
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
    <div class="col-md-6 col-md-offset-2">
         <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'total',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute'=>'saldo',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                    'format'=>'raw'
                  ],
                  [
                      'class' => 'kartik\grid\ActionColumn',
                      'template'=>'{view}',
                      'vAlign'=>'middle',
                  ],

            ];

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'containerOptions' => ['style'=>'overflow: false'], // only set when $responsive = false
                'export' => false,
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                'floatHeader' => false,
                'showPageSummary' => true,
                'panel' => [
                    'heading'=>'Cuentas X Cobrar',
                    'type' => GridView::TYPE_WARNING
                ],
            ]);

        ?>
    </div>
    <div class="col-md-6 col-md-offset-2">
         <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'total',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute'=>'saldo',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                    'format'=>'raw'
                  ],
                  [
                      'class' => 'kartik\grid\ActionColumn',
                      'template'=>'{view}',
                      'vAlign'=>'middle',
                  ],

            ];

            echo GridView::widget([
                'dataProvider' => $dataProvider2,
                'filterModel' => $searchModel2,
                'columns' => $gridColumns,
                'containerOptions' => ['style'=>'overflow: false'], // only set when $responsive = false
                'export' => false,
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                'floatHeader' => false,
                'showPageSummary' => true,
                'panel' => [
                    'heading'=>'Ventas pagadas',
                    'type' => GridView::TYPE_SUCCESS
                ],
            ]);

        ?>
    </div>
  </div>
</div>
