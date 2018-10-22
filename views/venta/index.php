<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\EstadoCaja;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        if($privilegio[0]['crear_venta'] == 1 && $estado_caja[0]['estado_caja'] == 1)
            echo Html::a('Nueva venta', ['create'], ['class' => 'btn btn-success']);
        else
            echo " <a href='../caja/index'>Click aquí para abrir caja</a>";
         ?>
    </p>

    <div class="col-md-6">
    <?php Pjax::begin(); ?>
            <?php
                $gridColumns = [
                    [
                        'attribute' => 'id',
                        'vAlign'=>'middle',
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'id_cliente',
                        'vAlign'=>'middle',
                        'value'=>function ($model) {
                            return $model->obtenerNombreCliente($model->id_cliente);
                          },
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'id_vendedor',
                        'vAlign'=>'middle',
                        'value'=>function ($model) {
                            return $model->obtenerNombreTrabajador($model->id_vendedor);
                          },
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'total',
                        'vAlign'=>'middle',
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    'create_time',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{view}{delete}',
                        'vAlign'=>'middle',
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
                        'heading'=>'Ventas Pagadas',
                        'type' => GridView::TYPE_SUCCESS
                    ],
                ]);

            ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-6">
    <?php Pjax::begin(); ?>
            <?php
                $gridColumns = [
                    [
                        'attribute' => 'id',
                        'vAlign'=>'middle',
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'id_cliente',
                        'vAlign'=>'middle',
                        'value'=>function ($model) {
                            return $model->obtenerNombreCliente($model->id_cliente);
                          },
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'total',
                        'vAlign'=>'middle',
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    [
                        'attribute' => 'saldo',
                        'vAlign'=>'middle',
                        'headerOptions'=>['class'=>'kv-sticky-column'],
                        'contentOptions'=>['class'=>'kv-sticky-column'],
                    ],
                    'create_time',
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{view}{delete}',
                        'vAlign'=>'middle',
                    ],
                ];

                echo GridView::widget([
                    'dataProvider' => $noPagadas,
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
                      'heading'=>'Ventas X Cobrar',
                      'type' => GridView::TYPE_WARNING
                    ],
                ]);

            ?>
        <?php Pjax::end(); ?>
    </div>
</div>
