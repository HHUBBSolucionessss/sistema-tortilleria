<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sucursal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sucursals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sucursal-view">

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
            'id_domicilio',
            'nombre',
            'calle',
            'numero_ext',
            'numero_int',
            'cp',
            'colonia',
            'estado',
            'ciudad',
            'telefono1',
            'telefono2',
            'fax',
            'email:email',
            'logotipo',
            'web',
            'rfc',
            'asignada',
            'eliminado',
            'create_user',
            'create_time',
            'update_user',
            'update_time',
        ],
    ]) ?>

</div>
