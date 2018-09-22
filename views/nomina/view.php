<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use yii\bootstrap\Modal;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = 'Nómina '. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nómina', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-4">
      <?php
      $user= new User();;
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
                  'heading'=>'Nómina ' . $model->id,
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
                    'attribute'=>'id_trabajador',
                    'format'=>'raw',
                    'value'=>$model->obtenerNombreTrabajador($model->id_trabajador),
                    'displayOnly'=>true,
                ],
                'sueldo_base',
                'sueldo',
                'descuentos',
                'bonos',
                'total',
                'notas',
                'dias_trabajados',
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
      <p>
        <?php
        if($privilegio[0]['cancelar_venta'] == 1)
        echo Html::a(Yii::t('app', 'Cancelar nómina'), ['cancelar', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
      </p>

</div>
