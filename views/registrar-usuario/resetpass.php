<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="resetpass-form">

  <h1><?php echo "Cambiar contraseña" ?> </h1>

  <?php $form = ActiveForm::begin(); ?>

  <div class="form-group">
   <?= $form->field($searchModel, "password_reset_token")->input("password",[ 'placeholder' => 'Escriba la nueva contraseña']) ?>
  </div>

  <?= Html::submitButton("Reset password", ["class" => "btn btn-primary"]) ?>

  <?php ActiveForm::end(); ?>

</div>
