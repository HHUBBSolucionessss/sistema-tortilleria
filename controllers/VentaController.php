<?php

namespace app\controllers;

use Yii;
use app\models\Venta;
use app\models\VentaDetallada;
use app\models\VentaSearch;
use app\models\RegistroSistema;
use app\models\Privilegio;
use app\models\PagoVenta;
use app\models\EstadoCaja;
use app\models\Caja;
use app\models\cliente;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VentaController implements the CRUD actions for Venta model.
 */
class VentaController extends Controller
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
     * Lists all Venta models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new VentaSearch();
      $id_current_user = Yii::$app->user->identity->id;

      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $estado_caja = new EstadoCaja();
      $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'estado_caja' => $estado_caja,
          'privilegio'=>$privilegio,
      ]);
    }

    /**
     * Displays a single Venta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $searchModel = new VentaSearch();
      $id_current_user = Yii::$app->user->identity->id;

      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $estado_caja = new EstadoCaja();
      $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();

      return $this->render('view', [
          'model' => $this->findModel($id),
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'estado_caja' => $estado_caja,
          'privilegio'=>$privilegio,
      ]);
    }

    /**
     * Creates a new Venta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['apertura_caja'] == 1){
        $model = new Venta();
        $registroSistema = new RegistroSistema();
        $modelsVentaDetallada = [new VentaDetallada];

        if ($model->load(Yii::$app->request->post())) {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = 1;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha realizado una venta";
          $registroSistema->id_sucursal = 1;

          $modelVentaDetallada = Model::createMultiple(VentaDetallada::classname());
          Model::loadMultiple($modelVentaDetallada, Yii::$app->request->post());
          // ajax validation
          if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelVentaDetallada),
                    ActiveForm::validate($model)
                );
            }

          // validate all models
          $valid = $model->validate();
          $validacion=Model::validateMultiple($modelVentaDetallada);

          //$valid =  $validacion && $valid;
          if ($valid)
          {
              $transaction = \Yii::$app->db->beginTransaction();
              try
              {
                  if ($flag = $model->save(false))
                  {
                      foreach ($modelVentaDetallada as $modelVentaDetallada)
                      {
                          $modelVentaDetallada->id_venta = $model->id;
                          if (! ($flag = $modelVentaDetallada->save(false)))
                          {
                              $transaction->rollBack();
                              break;
                          }
                      }
                  }
                  if ($flag)
                  {
                      $transaction->commit();
                      return $this->redirect(['view', 'id' => $model->id]);
                  }
              } catch (Exception $e) {
                  $transaction->rollBack();
              }
          }
        }
      }
      else{
        return $this->redirect(['index']);
      }

      return $this->render('_form', [
          'model' => $model,
          'modelVentaDetallada' => (empty($modelVentaDetallada)) ? [new VentaDetallada] : $modelsVentaDetallada
      ]);
    }

    /**
     * Updates an existing Venta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPagoVenta($id)
    {
        $registroSistema = new RegistroSistema();
        $pagoVenta = new PagoVenta();
        $estado_caja = new EstadoCaja();
        $caja = new Caja();
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();
        $totales = Yii::$app->db->createCommand('SELECT total,saldo FROM venta WHERE id = '.$id)->queryAll();

    if($privilegio[0]['apertura_caja'] == 1)
    {
      if ($pagoVenta->load(Yii::$app->request->post())) 
      {

        //CAJA
        $caja->id_sucursal = 1;
        $caja->descripcion="Pago a la venta ".$id;
        $caja->efectivo=$pagoVenta->ingreso;
        $caja->tarjeta=0;
        $caja->deposito=0;
        $caja->tipo_movimiento=0;
        $caja->tipo_pago=0;
        $caja->create_user=Yii::$app->user->identity->id;
        $caja->create_time=date('Y-m-d H:i:s');

        //Registro de sistema
        $registroSistema->descripcion=Yii::$app->user->identity->nombre." ha realizado un pago a la venta ". $id ." por un monto de  ".$pagoVenta->ingreso;
        $registroSistema->id_sucursal=1;

        //Pago venta
        $pagoVenta->id_venta = $id;
        $pagoVenta->create_user=Yii::$app->user->identity->id;
        $pagoVenta->create_time=date('Y-m-d H:i:s');


        if($pagoVenta->save())
        {
          return $this->redirect(['view', 'id' => $id]);
        }
      }
    }
    else{
      return $this->redirect(['index']);
    }

    return $this->renderAjax('pagoVenta', [
        'estado_caja' => $estado_caja,
        'privilegio'=>$privilegio,
        'totales'=>$totales,
        'pagoVenta'=>$pagoVenta,
    ]);
	}

    /**
     * Deletes an existing Venta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Venta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Venta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Venta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
