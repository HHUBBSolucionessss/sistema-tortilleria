<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Costales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
          <?php
              $gridColumns = [
                  ['class' => 'kartik\grid\SerialColumn'],
                  [
                    'attribute' => 'id_caja_ini',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute'=>'costales_ini',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute' => 'id_caja_fin',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute'=>'costales_fin',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute'=>'usados_dia',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute'=>'precio_dia',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
                  [
                    'attribute'=>'create_time',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                  ],
              ];

              echo GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => $gridColumns,
                  'containerOptions' => ['style'=>'overflow: false'], // only set when $responsive = false
                  'beforeHeader'=>[
                      [
                          'options'=>['class'=>'skip-export'] // remove this row from export
                      ]
                  ],
                  'toolbar' =>  [
                      '{export}',
                      '{toggleData}'
                  ],
                  'exportConfig' => [
                     GridView::EXCEL => [
                         'label' => 'Exportar a Excel',
                         'iconOptions' => ['class' => 'text-success'],
                         'showHeader' => true,
                         'showPageSummary' => true,
                         'showFooter' => true,
                         'showCaption' => true,
                         'filename' => 'exportacion-caja',
                         'alertMsg' => 'The EXCEL export file will be generated for download.',
                         'options' => ['title' => 'Microsoft Excel 95+'],
                         'mime' => 'application/vnd.ms-excel',
                         'config' => [
                         'worksheet' => 'ExportWorksheet',
                             'cssFile' => ''
                         ]
                     ],
                 ],
                  'pjax' => true,
                  'bordered' => true,
                  'striped' => false,
                  'condensed' => false,
                  'responsive' => true,
                  'hover' => true,
                  'floatHeader' => false,
                  'showPageSummary' => true,
                  'panel' => [
                      'type' => GridView::TYPE_PRIMARY
                  ],
              ]);

          ?>
      <?php Pjax::end(); ?>

</div>
