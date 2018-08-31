<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar Sesión';
?>
<div class="site-login">
  <div class='panel panel-info'>
    <div class='panel-heading'>
      <h1><?= Html::encode($this->title) ?></h1>
        <p>Por favor completa los siguientes campos:</p>
    </div>

    <div class="row panel-body">
      <div class="col-lg-12 center-block">
        <div class="row">
          <div class="col-lg-5">
              <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'login-form']); ?>

                  <?= $form->field($model, 'username')->Input(['autofocus' => true], ['placeholder' => "Usuario"]) ?>

                  <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Contraseña"]) ?>

                  <?= $form->field($model, 'rememberMe')->checkbox() ?>

                  <div class="form-group">
                      <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                  </div>

              <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
