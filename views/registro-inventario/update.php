<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegistroInventario */

$this->title = 'Update Registro Inventario: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Registro Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registro-inventario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
