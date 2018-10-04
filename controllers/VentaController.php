<?php

namespace app\controllers;

use Yii;
use app\models\Venta;
use app\models\VentaDetallada;
use app\models\VentaSearch;
use app\models\RegistroSistema;
use app\models\Privilegio;
use app\models\PagoVenta;
use app\models\Model;
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
      $id_sucursal = Yii::$app->user->identity->id_sucursal;

      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $noPagadas = $searchModel->noPagadas(Yii::$app->request->queryParams);
      $estado_caja = new EstadoCaja();

      $estado_caja = Yii::$app->db->createCommand('SELECT estado_caja FROM estado_caja WHERE id_sucursal = '.$id_sucursal)->queryAll();

      return $this->render('index', [
          'searchModel' => $searchModel,
          'noPagadas' => $noPagadas,
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
      $model = $this->findModel($id);
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if ($model->load(Yii::$app->request->post())) {

      $model = $this->findModel($id);
      Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
      return $this->render('view', [
          'model' => $model,
          'privilegio'=>$privilegio,
      ]);
    }

        return $this->render('view', [
            'model' => $model,
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
      $id_current_sucursal = Yii::$app->user->identity->id_sucursal;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

        if($privilegio[0]['apertura_caja'] == 1){
          $modelVenta = new Venta;
          $registroSistema= new RegistroSistema();
          $ventaProductos = [new VentaDetallada];
          if ($modelVenta->load(Yii::$app->request->post()))
          {
              $modelVenta->create_user=Yii::$app->user->identity->id;
              $modelVenta->id_sucursal = Yii::$app->user->identity->id_sucursal;
              $modelVenta->saldo= $modelVenta->total;
              $modelVenta->create_time=date('Y-m-d H:i:s');
              $registroSistema->save();
              $ventaProducto = Model::createMultiple(VentaDetallada::classname());
              Model::loadMultiple($ventaProducto, Yii::$app->request->post());
              // ajax validation
              if (Yii::$app->request->isAjax)
              {
                  Yii::$app->response->format = Response::FORMAT_JSON;
                  return ArrayHelper::merge(
                      ActiveForm::validateMultiple($ventaProducto),
                      ActiveForm::validate($modelVenta)
                  );
              }
              // validate all models
              $valid = $modelVenta->validate();
              //$modelTarifaDetallada->id_tarifa=0;
              //$valid =  $validacion && $valid;
              if ($valid)
              {
                  $transaction = \Yii::$app->db->beginTransaction();
                  try
                  {
                      if ($flag = $modelVenta->save(false))
                      {
                          foreach ($ventaProductos as $ventaProducto)
                          {
                              $ventaProducto->id_venta = $modelVenta->id;
                              if (! ($flag = $ventaProducto->save(false)))
                              {
                                  $transaction->rollBack();
                                  break;
                              }
                          }
                      }
                      if ($flag)
                      {
                          $transaction->commit();
                          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha realizado la venta con folio ".$modelVenta->id;
                          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

                          if($modelVenta->a_pagos == 0){
                            $registroSistema->save();
                            return $this->redirect(['view',
                            'id' => $modelVenta->id,
                            'id_current_sucursal'=>$id_current_sucursal
                          ]);
                          }
                          else{
                            $registroSistema->save();
                            return $this->redirect(['view',
                            'id' => $modelVenta->id,
                            'id_current_sucursal'=>$id_current_sucursal
                          ]);
                          }
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
            'modelVenta' => $modelVenta,
            'id_current_sucursal'=>$id_current_sucursal,
            'ventaProducto' => (empty($ventaProducto)) ? [new VentaDetallada] : $ventaProductos
        ]);
    }

    public function actionPagoVenta($id)
    {
        $registroSistema = new RegistroSistema();
        $pagoVenta = new PagoVenta();
        $estado_caja = new EstadoCaja();
        $caja = new Caja();
        $venta = new Venta();
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();
        $totales = Yii::$app->db->createCommand('SELECT total,saldo FROM venta WHERE id = '.$id)->queryAll();

    if($privilegio[0]['pago_venta'] == 1)
    {
      if ($pagoVenta->load(Yii::$app->request->post()))
      {

        //CAJA
        $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
        $caja->descripcion="Pago a la venta con folio ".$id;
        $caja->efectivo=$pagoVenta->ingreso;
        $caja->tipo_movimiento=0;
        $caja->tipo_pago=2;
        $caja->create_user=Yii::$app->user->identity->id;
        $caja->create_time=date('Y-m-d H:i:s');

        //VENTA
        $venta = new Venta();
        $venta = Venta::find()
        ->where(['id' => $id])
        ->one();

        $nuevoSaldo = $venta->saldo - $pagoVenta->ingreso;

        if($nuevoSaldo >= 0){

            $venta->saldo = $nuevoSaldo;

            //Registro de sistema
            $registroSistema->descripcion=Yii::$app->user->identity->nombre." ha realizado un pago a la venta ". $id ." por un monto de $".$pagoVenta->ingreso;
            $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;

            //Pago venta
            $pagoVenta->id_venta = $id;
            $pagoVenta->create_user=Yii::$app->user->identity->id;
            $pagoVenta->create_time=date('Y-m-d H:i:s');

            //$venta


            if($pagoVenta->save() && $caja->save() && $registroSistema->save() && $venta->save())
            {
              return $this->redirect(['view', 'id' => $id]);
            }
          }
          else{
            Yii::$app->session->setFlash('kv-detail-warning', 'No puedes pagar más de lo que resta.');
            return $this->redirect(['view', 'id'=>$id]);
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

  public function actionEfectivo($id)
  {
      $registroSistema = new RegistroSistema();
      $pagoVenta = new PagoVenta();
      $estado_caja = new EstadoCaja();
      $caja = new Caja();
      $venta = new Venta();
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
      $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();
      $totales = Yii::$app->db->createCommand('SELECT total,saldo FROM venta WHERE id = '.$id)->queryAll();

  if($privilegio[0]['pago_venta'] == 1)
  {
    if ($pagoVenta->load(Yii::$app->request->post()))
    {

      //CAJA
      $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
      $caja->descripcion="Ingreso de venta con folio ".$id;
      $caja->efectivo=$pagoVenta->ingreso;
      $caja->tipo_movimiento=0;
      $caja->tipo_pago=0;
      $caja->create_user=Yii::$app->user->identity->id;
      $caja->create_time=date('Y-m-d H:i:s');

      //VENTA
      $venta = new Venta();
      $venta = Venta::find()
      ->where(['id' => $id])
      ->one();

      $nuevoSaldo = $venta->saldo - $pagoVenta->ingreso;

      if($nuevoSaldo >= 0){

          $venta->saldo = $nuevoSaldo;

          //Registro de sistema
          $registroSistema->descripcion=Yii::$app->user->identity->nombre." ha realizado un pago a la venta ". $id ." por un monto de $".$pagoVenta->ingreso;
          $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;

          //Pago venta
          $pagoVenta->id_venta = $id;
          $pagoVenta->create_user=Yii::$app->user->identity->id;
          $pagoVenta->create_time=date('Y-m-d H:i:s');

          //$venta


          if($pagoVenta->save() && $caja->save() && $registroSistema->save() && $venta->save())
          {
            return $this->redirect(['view', 'id' => $id]);
          }
        }
        else{
          Yii::$app->session->setFlash('kv-detail-warning', 'No puedes pagar más de lo que resta.');
          return $this->redirect(['efectivo', 'id'=>$id]);
        }
    }
  }
  else{
    return $this->redirect(['index']);
  }

  return $this->render('efectivo', [
      'model' => $this->findModel($id),
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
       $model = $this->findModel($id);

       if($model->load(Yii::$app->request->post())){
         Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
         return $this->redirect(['view', 'id'=>$model->id]);
       }
     }

     public function actionCancel($id)
     {
       $model = $this->findModel($id);
       $id_current_user = Yii::$app->user->identity->id;
       $privilegio = Yii::$app->db->createCommand('SELECT cancelar_venta FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

       if($privilegio[0]['cancelar_venta'] == 1){
         $registroSistema= new RegistroSistema();
         $caja = new Caja();

         $venta = new Venta();
         $venta = Venta::find()
         ->where(['id' => $id])
         ->one();

         $pagoDeCaja = $venta->saldo - $venta->total;

         $venta->saldo = $venta->total;

         //CAJA
         $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
         $caja->descripcion="Cancelación de venta con folio ".$id;
         $caja->efectivo=$pagoDeCaja;
         $caja->tipo_movimiento=1;
         $caja->tipo_pago=0;
         $caja->create_user=Yii::$app->user->identity->id;
         $caja->create_time=date('Y-m-d H:i:s');

         $model->cancelada = 1;
         $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha cancelado la venta con folio ". $model->id. ". Se devolvieron $".-$pagoDeCaja;
         $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

         if($model->save() && $registroSistema->save() && $venta->save() && $caja->save()){
           Yii::$app->session->setFlash('kv-detail-success', 'La venta se ha cancelado correctamente');
           return $this->redirect(['index']);
         }
       }
       else{
         Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
         return $this->redirect(['view', 'id'=>$model->id]);
       }
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
