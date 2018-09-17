<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte General';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
      <?php
          echo DatePicker::widget([
              'name' => 'fecha_ini',
              'value' => date('Y-m-d'),
              'type' => DatePicker::TYPE_RANGE,
              'name2' => 'fecha_fin',
              'value2' => date('Y-m-d',strtotime("+1 days")),
              'pluginOptions' => [
                  'todayHighlight' => true,
                  'todayBtn' => true,
                  'format' => 'yyyy-mm-d',
                  'autoclose'=>true,
              ]
          ]);
      ?>

      <?php ActiveForm::end(); ?>

    <?php
    echo Html::button('Reporte general', ['value'=>Url::to('general'), 'class' => 'btn btn-success'])?>

</div>
