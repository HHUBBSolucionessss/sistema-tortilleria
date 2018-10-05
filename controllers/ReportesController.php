<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Caja;
use app\models\Banco;
use app\models\Boveda;
use app\models\Venta;
use app\models\Nomina;
use app\models\Cliente;

/**
 * PrivilegioController implements the CRUD actions for Privilegio model.
 */
class ReportesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Privilegio models.
     * @return mixed
     */
    public function actionIndex()
    {
      return $this->render('index');
    }

    public function actionGeneral()
    {
      return $this->render('general');
    }
    public function actionGanancia()
    {
      	if (Yii::$app->request->post())
		{
            $caja = new Caja();
            $caja2 = new Caja();
            $venta= new Venta();
            $boveda= new Boveda();
            $banco= new Banco();
            $banco2= new Banco();
            $nomina= new Nomina();
            $extras= new Caja();

            $precioCostal=$precioTortilla=$utilidad=$porcentajeUtilidad=$precioCostalLP=0;
            $ingresoCaja=$ventas=$ingresoBoveda=$ingresoBanco=$ingresoExtra=0;
            $gastoCaja=$pagoNominas=$gastoBanco=$gastoBoveda=$gastoGas=$gastoCompras=0;
            $fecha_inicio = Yii::$app->request->post('fecha_inicio'). ' 00:00:00';
            $fecha_fin = Yii::$app->request->post('fecha_fin'). ' 23:59:59';
            $id_sucursal = Yii::$app->user->identity->id_sucursal;

            $venta = Venta::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['id_sucursal' => $id_sucursal])
            ->sum('total');

            $caja = Yii::$app->db->createCommand('SELECT SUM(efectivo) AS efectivo FROM `caja` WHERE NOT (descripcion LIKE "Apertura de caja" OR descripcion LIKE "Cierre de caja") AND (tipo_movimiento = 0) AND (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
            ->bindValue(':fecha_inicio', $fecha_inicio)
            ->bindValue(':fecha_fin', $fecha_fin)
            ->bindValue(':id_sucursal', $id_sucursal)
            ->queryAll();

            $boveda = Boveda::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['tipo_movimiento' => 0])
            ->sum('efectivo');

            $banco = Banco::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['tipo_movimiento' => 0])
            ->where(['id_sucursal' => $id_sucursal])
            ->sum('deposito');

            $extras = Caja::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['tipo_movimiento' => 0])
            ->where(['tipo_pago' => 2])
            ->where(['id_sucursal' => $id_sucursal])
            ->sum('efectivo');

            $ingresos=[
                'ingresoCaja'=>$caja[0]['efectivo'],
                'ventas'=>$venta,
                'ingresoBoveda'=>$boveda,
                'ingresoBanco'=>$banco,
                'ingresoExtra'=>$extras
            ];

            $caja2 = Yii::$app->db->createCommand('SELECT SUM(efectivo) AS efectivo FROM `caja` WHERE NOT (descripcion LIKE "Apertura de caja" OR descripcion LIKE "Cierre de caja") AND (tipo_movimiento = 1) AND (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal) ')
            ->bindValue(':fecha_inicio', $fecha_inicio)
		        ->bindValue(':fecha_fin', $fecha_fin)
            ->bindValue(':id_sucursal', $id_sucursal)
            ->queryAll();

            $nomina = Nomina::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['id_sucursal' => $id_sucursal])
            ->sum('total');

            $banco2 = Banco::find()
            ->where(['between', 'create_time', $fecha_inicio, $fecha_fin])
            ->where(['id_sucursal' => $id_sucursal])
            ->where(['tipo_movimiento' => 1])
            ->sum('deposito');

            $gas = Yii::$app->db->createCommand('SELECT SUM(deposito) AS gas FROM `banco` WHERE (descripcion LIKE "COMPRA GAS LP") AND (tipo_movimiento = 1) AND (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
            ->bindValue(':fecha_inicio', $fecha_inicio)
            ->bindValue(':id_sucursal', $id_sucursal)
            ->bindValue(':fecha_fin', $fecha_fin)
            ->queryAll();

            $compras = Yii::$app->db->createCommand('SELECT SUM(deposito) AS compras FROM `banco` WHERE (descripcion LIKE "COMPRA MATERIAL") AND (tipo_movimiento = 1) AND (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
            ->bindValue(':fecha_inicio', $fecha_inicio)
            ->bindValue(':id_sucursal', $id_sucursal)
            ->bindValue(':fecha_fin', $fecha_fin)

            ->queryAll();

            $gastos=[
                'gastoCaja'=>-$caja2[0]['efectivo'],
                'pagoNominas'=>$nomina,
                'gastoBanco'=>-$banco2,
                'gastoBoveda'=>$gastoBoveda,
                'gastoGas'=>-$gas[0]['gas'],
                'gastoCompras'=>-$compras[0]['compras']

            ];

            $ingresosTotal =  $ingresos['ventas'] +
                              $ingresos['ingresoCaja'] +
                              $ingresos['ingresoBoveda'] +
                              $ingresos['ingresoBanco'] +
                              $ingresos['ingresoExtra'];

            $gastosTotal =  $gastos['gastoCaja'] +
                            $gastos['pagoNominas'] +
                            $gastos['gastoBanco'] +
                            $gastos['gastoBoveda'] +
                            $gastos['gastoGas'] +
                            $gastos['gastoCompras'];

            $utilidadTotal = $ingresosTotal + (-$gastosTotal);

            $porUtilidad = ($utilidadTotal / $ingresosTotal) * 100;

            $precost = Yii::$app->db->createCommand('SELECT SUM(precio_dia) AS precio FROM costales WHERE (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
            ->bindValue(':fecha_inicio', $fecha_inicio)
		        ->bindValue(':fecha_fin', $fecha_fin)
            ->bindValue(':id_sucursal', $id_sucursal)
            ->queryAll();

            $precioLPCostal = $gas[0]['gas'] /  $precost[0]['precio'];

            $costal=[
                'precioCostal'=>$precost[0]['precio'],
                'precioTortilla'=>$precioTortilla,
                'utilidad'=>$utilidadTotal,
                'porcentajeUtilidad'=>$porUtilidad,
                'precioCostalLP'=>-$precioLPCostal
            ];


			//$dataProvider = $searchModel->buscarDisponibles(Yii::$app->request->post('fecha_entrada'),Yii::$app->request->post('fecha_salida'));
			return $this->renderAjax('ganancia', [
			'fecha_inicio'=>Yii::$app->request->post('fecha_inicio'),
            'fecha_fin'=>Yii::$app->request->post('fecha_fin'),
            'ingresos'=>$ingresos,
            'gastos'=>$gastos,
            'costal'=>$costal
			]);
		}
    }

}
