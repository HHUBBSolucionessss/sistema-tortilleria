<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-view">

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
            'id_cliente',
            'id_sucursal',
            'id_vendedor',
            'cancelada',
            'abierta',
            'subtotal',
            'impuesto',
            'descuento',
            'total',
            'saldo',
            'remision',
            'factura',
            'folio_factura',
            'tipo_pago',
            'terminacion_tarjeta',
            'terminal_tarjeta',
            'cargo_tarjeta',
            'folio_deposito',
            'a_pagos',
            'abonado',
            'create_user',
            'create_time',
            'update_user',
            'update_time',
            'cancel_user',
            'cancel_time',
        ],
    ]) ?>

</div>
