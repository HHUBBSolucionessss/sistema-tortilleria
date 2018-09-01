<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Tortillería Los Cuates';
?>

<div class="site-index">
    <div class="jumbotron">
      <h1>Selecciona la sucursal</h1>

      <?php
      //if($tipo_usuario[0]['tipo_usuario'] = 1)

      echo Html::a(Yii::t('app', 'Ir a la página principal'), ['../web/site/index'], ['class' => 'btn btn-info']) ?>

    </div>
  </div>
