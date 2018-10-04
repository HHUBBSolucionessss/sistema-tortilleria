<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\User;

use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\EstadoCaja;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BancoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Compra Gas LP';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><b>Total de litros: </b><?php echo $totales[0]['litros']?></p>
      <p><b>Total:</b> $<?php echo $totales[0]['total']?></p>
    <p>
        <?php
        if($privilegio[0]['crear_compra'] == 1)
         echo Html::button('Registrar pedido', ['value'=>Url::to('../compra/create'), 'class' => 'btn btn-success', 'id' => '_modalButtonApertura'])?>

      <?php
      if($privilegio[0]['crear_compra'] == 1 && $totales[0]['total'] != 0)
        echo Html::button('Pagar adeudo', ['value'=>Url::to('../compra/pagocompra'), 'class' => 'btn btn-warning', 'id' => 'modalButton']);?>
    </p>

    <?php
      Modal::begin([
        'header' => '<h4 style="color:#337AB7";>Pagar adeudo</h4>',
        'id' => 'modal',
        'size' => 'modal-md',
      ]);
      echo "<div id='modalContent'></div>";
      Modal::end();
    ?>

    <?php
      Modal::begin([
        'header' => '<h4 style="color:#337AB7";>Compra Gas LP</h4>',
        'id' => '_modalApertura',
        'size' => 'modal-md',
      ]);

      echo "<div id='_aperturaCaja'></div>";

      Modal::end();
    ?>

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
                    'attribute' => 'nombre_proveedor',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'total_litros',
                    'vAlign'=>'middle',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                ],
                [
                    'attribute' => 'precio_litro',
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
