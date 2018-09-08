<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

use app\models\Sucursal;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrarUsuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registrar-usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->input("password") ?>

    <div class="col-md-6">

      <?= $form->field($model, 'id_sucursal')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Sucursal::find()->all(), 'id', 'id'),
                'value'=>1,
                'options' => ['placeholder' => 'Asignar una sucursal ...', 'select'=>'0'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

      </div>

    <div class="form-group">
        <?= Html::submitButton('Registrar', ['class' => 'btn btn-success'], ['id'=>'_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
