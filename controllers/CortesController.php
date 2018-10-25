<?php

namespace app\controllers;
use Yii;
use app\models\Caja;
use app\models\CajaSearch;
use yii\web\Controller;
use app\models\Costales;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * CajaController implements the CRUD actions for Caja model.
 */
class CortesController extends Controller
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
     * Lists all Caja models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new CajaSearch();
      $dataProvider = $searchModel->cortes(Yii::$app->request->queryParams);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }

    /**
     * Displays a single Caja model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionView($id){

       $sucursal = Yii::$app->user->identity->id_sucursal;

       $totalCaja = Yii::$app->db->createCommand('SELECT Sum(efectivo) FROM caja WHERE (id_sucursal = :sucursal) AND id=(SELECT MAX(id) FROM caja WHERE descripcion = "Apertura de caja" AND id < :id)')
            ->bindValue(':sucursal', $sucursal)
            ->bindValue(':id', $id)
            ->queryAll();

       $totalesRetirado = Yii::$app->db->createCommand('SELECT * FROM caja WHERE id = :id AND id_sucursal = :sucursal')
       ->bindValue(':sucursal', $sucursal)
       ->bindValue(':id', $id)
       ->queryAll();

       $apertura = Yii::$app->db->createCommand('SELECT create_time FROM caja WHERE id=(SELECT MAX(id) FROM caja WHERE descripcion = "Apertura de caja" AND id < :id) AND id_sucursal = :sucursal')
       ->bindValue(':sucursal', $sucursal)
       ->bindValue(':id', $id)
       ->queryAll();

       $cierre = Yii::$app->db->createCommand('SELECT create_time FROM caja WHERE id = :id')
       ->bindValue(':id', $id)
       ->queryAll();

       $costales = Yii::$app->db->createCommand('SELECT id, costales_ini, costales_fin FROM costales WHERE id=(SELECT MAX(id) FROM costales WHERE id_caja_fin = :id) AND id_sucursal = :sucursal')
       ->bindValue(':sucursal', $sucursal)
       ->bindValue(':id', $id)
       ->queryAll();

       $venta = Yii::$app->db->createCommand('SELECT SUM(subtotal) AS subtotal FROM venta WHERE (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
       ->bindValue(':fecha_inicio', $apertura[0]['create_time'])
       ->bindValue(':fecha_fin', $cierre[0]['create_time'])
       ->bindValue(':id_sucursal', $sucursal)
       ->queryAll();

       $extras = Caja::find()
       ->where(['tipo_pago' => 2])
       ->sum('efectivo');

       $caja = Yii::$app->db->createCommand('SELECT SUM(efectivo) AS efectivo FROM `caja` WHERE NOT (descripcion LIKE "Apertura de caja" OR descripcion LIKE "Cierre de caja") AND (tipo_movimiento = 1) AND (create_time BETWEEN :fecha_inicio AND :fecha_fin) AND (id_sucursal = :id_sucursal)')
       ->bindValue(':fecha_inicio', $apertura[0]['create_time'])
       ->bindValue(':fecha_fin', $cierre[0]['create_time'])
       ->bindValue(':id_sucursal', $sucursal)
       ->queryAll();

       if($extras == null){
           $extras = 0;
       }

       $costal = $costales[0]['costales_ini'] - $costales[0]['costales_fin'];

       $cos = new Costales();
       $cos = Costales::find()
       ->where(['id' => $costales[0]['id']])
       ->one();

       $precioCostal = $venta[0]['subtotal'] / $costal;

       $cos->precio_dia = $precioCostal;
       $cos->usados_dia = $costal;

       $cos->save();

       $searchModel = new CajaSearch();
       $dataProvider = $searchModel->buscarMovimientosCierre(Yii::$app->request->queryParams);
       $content = $this->renderPartial('../caja/corteCaja',[
           'dataProvider' => $dataProvider,
           'totalesRetirados'=>$totalesRetirado,
           'totalCaja'=>$totalCaja,
           'costales'=>$costales,
           'precioCostal'=>$precioCostal,
       ]);

       $pdf = new Pdf([
           'mode' => Pdf::MODE_CORE,
           'format' => Pdf::FORMAT_A4,
           'orientation' => Pdf::ORIENT_PORTRAIT,
           'destination' => Pdf::DEST_BROWSER,
           'content' => $content,
           'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
           'cssInline' => '.kv-heading-1{font-size:18px}',
           'options' => ['title' => 'Reporte Cierre'],
           'methods' => [
               'SetHeader'=>['Reporte de cierre de caja '. date('d-m-Y')],
               'SetFooter'=>['Página {PAGENO}'],
           ]
       ]);
       return $pdf->render();

     }

    /**
     * Finds the Caja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Caja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Caja::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
