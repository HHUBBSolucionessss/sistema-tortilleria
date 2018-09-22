<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nómina';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nomina-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?php
      //if($privilegio[0]['crear_trabajador'] == 1)
        echo Html::a('Crear nómina', ['create'], ['class' => 'btn btn-success'])?>
    </p>

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
                  'attribute' => 'id_trabajador',
                  'vAlign'=>'middle',
                  'value'=>function ($model) {
                      return $model->obtenerNombreTrabajador($model->id_trabajador);
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
                  'attribute' => 'notas',
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
