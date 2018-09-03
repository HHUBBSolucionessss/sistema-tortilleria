<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Venta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_cliente',
            'id_sucursal',
            'id_vendedor',
            'cancelada',
            //'abierta',
            //'subtotal',
            //'impuesto',
            //'descuento',
            //'total',
            //'saldo',
            //'remision',
            //'factura',
            //'folio_factura',
            //'tipo_pago',
            //'terminacion_tarjeta',
            //'terminal_tarjeta',
            //'cargo_tarjeta',
            //'folio_deposito',
            //'a_pagos',
            //'abonado',
            //'create_user',
            //'create_time',
            //'update_user',
            //'update_time',
            //'cancel_user',
            //'cancel_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
