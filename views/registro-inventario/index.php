<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use app\models\User;

use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\EstadoCaja;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BovedaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registro de Inventario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boveda-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?php
    if($privilegio[0]['crear_usuario'] == 1)
    echo Html::a('Realizar inventario', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?php
    Modal::begin([
      'header' => '<h4 style="color:#337AB7";>Registro Inventario</h4>',
      'id' => 'modal',
      'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

  ?>

<?php Pjax::begin(); ?>
      <?php
          $gridColumns = [
              ['class' => 'kartik\grid\SerialColumn'],
              [
                  'attribute' => 'id',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'id_sucursal',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                'attribute'=>'estado',
                'vAlign'=>'middle',
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                'attribute'=>'nota',
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
