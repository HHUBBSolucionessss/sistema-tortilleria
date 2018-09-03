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
        if($estado_caja[0]['estado_caja'] == 1)
         echo Html::button('Nueva venta', ['value'=>Url::to('../venta/create'), 'class' => 'btn btn-success', 'id' => '_modalButtonApertura'])?>
    </p>

    <?php
      Modal::begin([
        'header' => '<h4 style="color:#337AB7";>Movimientos Depósitos</h4>',
        'id' => '_modalApertura',
        'size' => 'modal-md',
      ]);

      echo "<div id='_aperturaCaja'></div>";

      Modal::end();
    ?>

<?php Pjax::begin(); ?>
        <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'id_cliente',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'id_vendedor',
                    'vAlign'=>'middle',
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
                    'type' => GridView::TYPE_PRIMARY
                ],
            ]);

        ?>
    <?php Pjax::end(); ?>

</div>
