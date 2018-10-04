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

      <?= $form->field($modelSucursal, 'id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Sucursal::find()->where(['eliminado' => 0])->all(), 'id', 'nombre'),
                'value'=>1,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'id'=> '_sucursal',
            ]);
            ?>

            <div class="form-group">
                <?= Html::submitButton('Continuar', ['class' => 'btn btn-info']) ?>
            </div>

          <?php ActiveForm::end(); ?>

      </div>
  </div>
