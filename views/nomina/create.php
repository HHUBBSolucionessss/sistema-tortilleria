<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Nomina */

$this->title = 'Crear Nómina';
$this->params['breadcrumbs'][] = ['label' => 'Nómina', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nomina-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
