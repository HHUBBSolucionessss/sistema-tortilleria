<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\Caja;
use app\models\User;

use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CajaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Corte de caja';
?>
<div class="caja-index">


    <?php $form = ActiveForm::begin(); ?>

    <p>Total retirado</p>
    <br>
      <p>Efectivo Retirado: $ <?php echo -($totalesRetirados[0]['efectivo'])?></p>
    <br>
    <p>Total en caja</p>
    <br>
      <p>Efectivo: $ <?=$totalCaja[0]['Sum(efectivo)']?></p>
    <br>


    <br>
    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(); ?>
            <?php
                $gridColumns = [
                  [
                      'attribute' => 'id',
                      'label' => 'Folio',
                  ],
                  [
                      'attribute' => 'descripcion',
                  ],
                  [
                    'attribute'=>'tipo_movimiento',
                    'vAlign'=>'middle',
                    'value'=>function ($model, $key, $index) {
                        return $model->obtenerTipoMovimiento($model->tipo_movimiento);
                      },
                      'format'=>'raw'
                  ],
                  'efectivo',
                  [
                      'attribute'=>'create_user',
                      'vAlign'=>'middle',
                      'value'=>function ($model, $key, $index) {
                          $usuario= new User();
                          return $usuario->obtenerNombre($model->create_user);
                      },
                      'format'=>'raw'
                  ],
                ];

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                ]);

            ?>

        <?php Pjax::end(); ?>

</div>
