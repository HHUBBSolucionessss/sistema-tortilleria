<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Boveda */

$this->params['breadcrumbs'][] = ['label' => 'Bovedas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="boveda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
