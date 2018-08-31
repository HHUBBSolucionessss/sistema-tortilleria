<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SucursalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sucursales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursal-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
    <?php
//    if($privilegio[0]['apertura_caja'] == 1)
      echo Html::button('Crear sucursal', ['value'=>Url::to('../sucursal/create'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
  </p>

  <?php
    Modal::begin([
      'header' => '<h4 style="color:#337AB7";>Crear sucursal</h4>',
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
                  'attribute' => 'nombre',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'calle',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'numero_ext',
                  'label' => 'Teléfono',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'colonia',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'telefono1',
                  'label'=>'Teléfono',
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
                     'filename' => 'exportacion-huespedes',
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
