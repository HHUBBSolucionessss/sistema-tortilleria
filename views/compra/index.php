<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Compra', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_proveedor',
            'id_sucursal',
            'id_comprador',
            'id_ctdestino',
            //'id_ctorigen',
            //'subtotal',
            //'impuesto',
            //'descuento',
            //'total',
            //'tipo_pago',
            //'num_cheque',
            //'beneficiario',
            //'folio_terminal',
            //'comision',
            //'referencia',
            //'concepto_pago',
            //'remision',
            //'factura',
            //'folio_remision',
            //'folio_factura',
            //'a_pagos',
            //'abonado',
            //'cancelada',
            //'estado',
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
