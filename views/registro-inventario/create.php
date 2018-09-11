<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegistroInventario */
$this->title = 'Nuevo Registro Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Registro Inventario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-inventario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
