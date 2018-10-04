<?php

namespace app\controllers;

use Yii;
use app\models\Compra;
use app\models\CompraSearch;
use app\models\PagoCompra;
use app\models\Banco;
use app\models\RegistroSistema;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
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
     * Lists all Compra models.
     * @return mixed
     */
     public function actionIndex()
     {
         $searchModel = new CompraSearch();
         $id_current_user = Yii::$app->user->identity->id;
         $id_sucursal = Yii::$app->user->identity->id_sucursal;

         $privilegio = Yii::$app->db->createCommand('SELECT crear_compra FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
         $totales = Yii::$app->db->createCommand('SELECT SUM(total_litros) AS litros, SUM(total) AS total FROM compra WHERE estado = 1')->queryAll();

         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
             'privilegio'=>$privilegio,
             'totales'=>$totales
         ]);
     }

    /**
     * Displays a single Compra model.
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
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT crear_compra FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_compra'] == 1){

        $model = new Compra();
        $banco = new Banco();
        $registroSistema= new RegistroSistema();
        if ($model->load(Yii::$app->request->post()))
        {
          $totales = Yii::$app->db->createCommand('SELECT Sum(total_litros) AS litros, SUM(total) AS total FROM compra')->queryAll();

          $model->create_user = Yii::$app->user->identity->id;
          $model->a_pagos = 1;
          $model->create_time = date('Y-m-d H:i:s');
          $model->id_sucursal = Yii::$app->user->identity->id_sucursal;

          $registroSistema->descripcion = Yii::$app->user->identity->nombre .' realizó una compra de Gas LP de $'. $model->total;
          $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;

            if($model->a_pagos == 0){
              $banco->id_sucursal = Yii::$app->user->identity->id_sucursal;
              $banco->id_cuenta = $model->id_cuenta;
              $banco->descripcion = $model->descripcion;
              $banco->deposito = -$model->total;
              $banco->tipo_movimiento = 1;
              $banco->create_user = Yii::$app->user->identity->id;
              $banco->create_time = date('Y-m-d H:i:s');

                if($model->save() && $registroSistema->save() && $banco->save())
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else{
              if($model->save() && $registroSistema->save())
              {
                  return $this->redirect(['view', 'id' => $model->id]);
              }
            }
          }
        }
        else{
          return $this->redirect(['index']);
        }
      return $this->renderAjax('create', [
          'model' => $model,
      ]);
    }

    public function actionPagocompra()
    {
        $registroSistema = new RegistroSistema();
        $pagoCompra = new PagoCompra();
        $banco = new Banco();
        $compra = new Compra();
        $id_current_user = Yii::$app->user->identity->id;
        $privilegio = Yii::$app->db->createCommand('SELECT crear_compra FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

        //COMPRA
        $compra = Compra::find()
        ->where(['estado' => 1])
        ->sum('total');

    if($privilegio[0]['crear_compra'] == 1)
    {
      if ($pagoCompra->load(Yii::$app->request->post()))
      {
        //BANCO
        $banco->id_sucursal=Yii::$app->user->identity->id_sucursal;
        $banco->id_cuenta=$pagoCompra->id_cuenta;
        $banco->descripcion="COMPRA GAS LP";
        $banco->deposito=-$pagoCompra->ingreso;
        $banco->tipo_movimiento=1;
        $banco->create_user=Yii::$app->user->identity->id;
        $banco->create_time=date('Y-m-d H:i:s');

        //Registro de sistema
        $registroSistema->descripcion=Yii::$app->user->identity->nombre." ha realizado un pago de Gas LP por un monto de $".$pagoCompra->ingreso;
        $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;

        //Pago compra
        $pagoCompra->create_user=Yii::$app->user->identity->id;
        $pagoCompra->create_time=date('Y-m-d H:i:s');

          if($pagoCompra->save() && $banco->save() && $registroSistema->save())
          {
            $totalNuevo = Yii::$app->db->createCommand('UPDATE compra SET estado = 0 WHERE estado = 1')->execute();
            return $this->redirect(['index']);
          }
        }
      }
    else{
      return $this->redirect(['index']);
    }

    return $this->renderAjax('pagocompra', [
        'privilegio'=>$privilegio,
        'compra'=>$compra,
        'pagoCompra'=>$pagoCompra,
    ]);
	}

    /**
     * Updates an existing Compra model.
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

    /**
     * Deletes an existing Compra model.
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
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
