<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Trabajadores */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trabajadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'sucursal_id',
                'nombre',
                'apellidos',
                'puesto',
                'telefono',
                'celular',
                'email:email',
                'direccion',
                'ciudad',
                'estado',
                'cp',
                'sueldo',
                'nomina',
                'fecha_inicio',
                'fecha_fin',
                'imagen',
                'huella',
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
                  [
                      'attribute'=>'update_user',
                      'format'=>'raw',
                      'displayOnly'=>true,
                  ],
                  [
                      'attribute'=>'update_time',
                      'format'=>'raw',
                      'displayOnly'=>true,
                  ],
              ]
          ]);

      ?>
      </div>

</div>
