<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrabajadorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trabajadors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajador-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trabajador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sucursal_id',
            'nombre',
            'apellidos',
            'puesto',
            //'telefono',
            //'celular',
            //'email:email',
            //'direccion',
            //'ciudad',
            //'estado',
            //'cp',
            //'sueldo',
            //'nomina',
            //'fecha_inicio',
            //'fecha_fin',
            //'imagen',
            //'huella',
            //'eliminado',
            //'create_user',
            //'create_time',
            //'update_user',
            //'update_time',
            //'delete_user',
            //'delete_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
