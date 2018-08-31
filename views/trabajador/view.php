<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Trabajador */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trabajadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajador-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sucursal_id',
            'nombre',
            'apellidos',
            'puesto',
            'telefono',
            'celular',
            'email:email',
            'direccion',
            'ciudad',
            'estado',
            'cp',
            'sueldo',
            'nomina',
            'fecha_inicio',
            'fecha_fin',
            'imagen',
            'huella',
            'eliminado',
            'create_user',
            'create_time',
            'update_user',
            'update_time',
            'delete_user',
            'delete_time',
        ],
    ]) ?>

</div>
