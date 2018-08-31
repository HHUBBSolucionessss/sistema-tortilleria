<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrarUsuario */

$this->title = 'Vista del usuario '. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registrar-usuario-view">


    <h1><?= Html::encode($this->title) ?></h1>


    <div class="col-md-4">
        <?php
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
                      'label'=>'ID',
                      'displayOnly'=>true,
                    ],
                    'nombre',
                    'username',
                    'email:email',
                    [
                        'attribute'=>'status',
                        'label'=>'Estado',
                        'format'=>'raw',
                        'value'=>$model->status ? '<span class="label label-success">Activo </span>' : '<span class="label label-danger">Inactivo</span>',
                        'type'=>DetailView::INPUT_SWITCH,
                        'widgetOptions' =>
                        [
                            'pluginOptions' =>
                            [
                                'onText' => 'Activa',
                                'offText' => 'Inactiva',
                            ]
                        ],
                    ],
                ]
            ]);

        ?>
        </div>

        <div class="privilegios">

          <p>
            <?php
            if($privilegio[0]['apertura_caja'] == 1)
            echo Html::a(Yii::t('app', 'Definir privilegios'), ['../web/privilegio/update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
          </p>

          <?php
            Modal::begin([
              'header' => '<h4 style="color:#337AB7";>Definir privilegios</h4>',
              'id' => 'modal',
              'size' => 'modal-lg',
            ]);

            echo "<div id='modalContent'></div>";

            Modal::end();

          ?>

        </div>


</div>
