<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Sucursal;

$this->title = 'Tortillería Los Cuates';
?>

<div class="site-index">
    <div class="jumbotron">
      <h1>Selecciona la sucursal</h1>

      <script type="text/javascript">

      $(document).on('click', '#_ibre', function(){
              var sucursal;
              var sucursal = $("#_sucursal");

              <?= $sucursal ?> = sucursal;
            });

      </script>

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($modelSucursal, 'id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Sucursal::find()->all(), 'id', 'nombre'),
                'value'=>1,
                'options' => ['placeholder' => 'Elige una sucursal ...', 'select'=>'0'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'id'=> '_sucursal',
            ]);
            ?>

            <?php

            echo Html::a(Yii::t('app', 'Continuar'), ['multiusuario', 'id_sucursal' => $sucursal], ['class' => 'btn btn-info']) ?>

          </div>

      <?php ActiveForm::end(); ?>
  </div>
