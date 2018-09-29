<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trabajadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?php
      if($privilegio[0]['crear_trabajador'] == 1)
        echo Html::button('Crear trabajador', ['value'=>Url::to('../trabajador/create'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

  <?php
    Modal::begin([
      'header' => '<h4 style="color:#337AB7";>Crear trabajador</h4>',
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
                  'attribute' => 'apellidos',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'telefono',
                  'vAlign'=>'middle',
                  'headerOptions'=>['class'=>'kv-sticky-column'],
                  'contentOptions'=>['class'=>'kv-sticky-column'],
              ],
              [
                  'attribute' => 'email',
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
