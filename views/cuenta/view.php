<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\User;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuenta-view">

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
                  'heading'=>'Cuenta ' . $model->nombre,
                  'type'=>DetailView::TYPE_INFO,
              ],
              'attributes'=>
              [
                [
                    'attribute'=>'id',
                    'format'=>'raw',
                    'displayOnly'=>true,
                ],
                'nombre',
                'num_cuenta',
                'clabe',
              ]
          ]);

      ?>
      </div>

</div>
