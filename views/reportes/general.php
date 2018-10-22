<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte General';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

        <div class="col-md-12">
            <div class="panel panel-info">
            <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
                    <?php
                    echo DatePicker::widget([
                        'name' => 'fecha_inicio',
                        'value' => date('Y-m-d', strtotime("-7 days")),
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'fecha_fin',
                        'value2' => date('Y-m-d'),
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'todayBtn' => true,
                            'format' => 'yyyy-mm-d',
                            'autoclose' => true,
                        ]
                    ]);
                    ?>

              <br>  <?php AjaxSubmitButton::begin([
                        'label' => 'Buscar',
                        'ajaxOptions' => [
                            'type' => 'POST',
                            'url' => \yii\helpers\Url::to(['reportes/ganancia']),
                            'success' => new \yii\web\JsExpression('function(html){
                        $("#output").html("");
                        $("#output").html(html);
                        }'),
                        ],
                        'options' => ['class' => 'customclass', 'type' => 'submit', 'class' => 'btn btn-info', 'id' => 'modalButton'],
                    ]);
                    AjaxSubmitButton::end();
                    ?>
          </br>

           <?php ActiveForm::end(); ?>

            <div id="output"></div>
            </div>

            </div>
        </div>
    </div>

</div>
