<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-view">

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
            'id_proveedor',
            'id_sucursal',
            'id_comprador',
            'id_ctdestino',
            'id_ctorigen',
            'subtotal',
            'impuesto',
            'descuento',
            'total',
            'tipo_pago',
            'num_cheque',
            'beneficiario',
            'folio_terminal',
            'comision',
            'referencia',
            'concepto_pago',
            'remision',
            'factura',
            'folio_remision',
            'folio_factura',
            'a_pagos',
            'abonado',
            'cancelada',
            'estado',
            'create_user',
            'create_time',
            'update_user',
            'update_time',
            'cancel_user',
            'cancel_time',
        ],
    ]) ?>

</div>
