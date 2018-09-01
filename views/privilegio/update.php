<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Privilegio */

$this->title = Yii::t('app', 'Asignar Privilegios: ' . $model->id_usuario, [
    'nameAttribute' => '' . $model->id_usuario,
]);
$this->title = 'Asignar Privilegios '. $model->id_usuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['/registrar-usuario/index']];
$this->params['breadcrumbs'][] = ['label' => 'Vista del usuario '.$model->id_usuario, 'url' => ['/registrar-usuario/view?id='.$model->id_usuario]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="privilegio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
