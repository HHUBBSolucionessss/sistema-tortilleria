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
            $venta= new Venta();
            $boveda= new Boveda();
            $banco= new Banco();
            $nomina= new Nomina();

            $precioCostal=$precioTortilla=$utilidad=$porcentajeUtilidad=$precioCostalLP=0;
            $ingresoCaja=$ventas=$ingresoBoveda=$ingresoBanco=$ingresoExtra=0;
            $gastoCaja=$pagoNominas=$gastoBanco=$gastoBoveda=$gastoGas=$gastoCompras=0;

            $ingresos=[
                'ingresoCaja'=>$ingresoCaja,
                'ventas'=>$ventas=0,
                'ingresoBoveda'=>$ingresoBoveda,
                'ingresoBanco'=>$ingresoBanco,
                'ingresoExtra'=>$ingresoExtra
            ];
            $gastos=[
                'gastoCaja'=>$gastoCaja,
                'pagoNominas'=>$pagoNominas,
                'gastoBanco'=>$gastoBanco,
                'gastoBoveda'=>$gastoBoveda,
                'gastoGas'=>$gastoGas,
                'gastoCompras'=>$gastoCompras

            ];
            $costal=[
                'precioCostal'=>$precioCostal,
                'precioTortilla'=>$precioTortilla,
                'utilidad'=>$utilidad,
                'porcentajeUtilidad'=>$porcentajeUtilidad,
                'precioCostalLP'=>$precioCostalLP
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
