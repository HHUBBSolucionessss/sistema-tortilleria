<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Caja;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Caja */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Tortillería Los Cuates';
?>

<div class="info-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3>Se realizó el corte de caja correctamente</h3>
    <p>
      <?= Html::a('Regresar', ['caja/index'], ['class'=>'btn']) ?>
      <?= Html::a('Generar PDF', ['caja/info'], ['class'=>'btn', 'target'=>'_blank']) ?>
    </p>

    <?php ActiveForm::end(); ?>

</div>
