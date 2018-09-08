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

      <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Sucursal::find()->all(), 'id', 'nombre'),
                'value'=>1,
                'options' => ['placeholder' => 'Elige una sucursal ...', 'select'=>'0'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

      <?php
      //if($tipo_usuario[0]['tipo_usuario'] = 1)

      echo Html::a(Yii::t('app', 'Ir a la página principal'), ['../web/site/index'], ['class' => 'btn btn-info']) ?>

      <?php ActiveForm::end(); ?>

    </div>
  </div>
