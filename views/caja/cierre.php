<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Caja;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Caja */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caja-form">

    <?php $form = ActiveForm::begin(); ?>
    <p>Efectivo: $ <?=$totalCaja[0]['Sum(efectivo)']?></p>

    <?= $form->field($model, 'efectivo')->Input(['autofocus' => true], ['placeholder' => "Efectivo a retirar"]) ?>

    <?= $form->field($costales, 'costales_fin')->Input(['autofocus' => true], ['placeholder' => "Costales restantes"])->label('Costales Cierre',['class'=>'label-class']) ?>

    <div class="form-group">
        <?= Html::submitButton('Cierre de caja', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
