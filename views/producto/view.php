<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
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
                    'attribute'=>'codigo',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                'nombre',
                'marca',
                'descripcion1',
                'costo',
                'precio',
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

</div>
