<?php

namespace app\controllers;

use Yii;
use app\models\Devoluciones;
use app\models\Caja;
use app\models\DevolucionDetallada;
use app\models\Model;
use app\models\DevolucionesSearch;
use yii\web\Controller;
use app\models\RegistroSistema;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DevolucionesController implements the CRUD actions for Devoluciones model.
 */
class DevolucionesController extends Controller
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
     * Lists all Devoluciones models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new DevolucionesSearch();
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'privilegio'=>$privilegio,
      ]);
    }

    /**
     * Displays a single Devoluciones model.
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
      Yii::$app->session->setFlash('kv-detail-warning', 'No se puede modificar una devolución');
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
     * Creates a new Devoluciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
       $id_current_user = Yii::$app->user->identity->id;
       $id_current_sucursal = Yii::$app->user->identity->id_sucursal;
         $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

         if($privilegio[0]['crear_devolucion'] == 1){
           $modelVenta = new Devoluciones;
           $registroSistema= new RegistroSistema();
           $caja = new Caja();
           $ventaProductos = [new DevolucionDetallada];
           if ($modelVenta->load(Yii::$app->request->post()))
           {
               $modelVenta->create_user=Yii::$app->user->identity->id;
               $modelVenta->id_sucursal = Yii::$app->user->identity->id_sucursal;
               $modelVenta->create_time=date('Y-m-d H:i:s');
               $ventaProducto = Model::createMultiple(DevolucionDetallada::classname());
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
                               $ventaProducto->id_devolucion = $modelVenta->id;
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

                           //CAJA
                           $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
                           $caja->descripcion="Devolución con folio ".$modelVenta->id;
                           $caja->efectivo=-$modelVenta->total;
                           $caja->tipo_movimiento=1;
                           $caja->tipo_pago=0;
                           $caja->create_user=Yii::$app->user->identity->id;
                           $caja->create_time=date('Y-m-d H:i:s');

                           $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha hecho una devolución de $".$modelVenta->total;
                           $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

                           if($registroSistema->save() && $caja->save())

                           return $this->redirect(['view',
                           'id' => $modelVenta->id,
                           'id_current_sucursal'=>$id_current_sucursal
                         ]);
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
             'ventaProducto' => (empty($ventaProducto)) ? [new DevolucionDetallada] : $ventaProductos
         ]);
     }

    /**
     * Updates an existing Devoluciones model.
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
     * Deletes an existing Devoluciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      $model = $this->findModel($id);
      Yii::$app->session->setFlash('kv-detail-warning', 'No se puede eliminar una devolución.');
      return $this->render('view', [
          'model' => $model,
          'privilegio'=>$privilegio,
      ]);
    }

    /**
     * Finds the Devoluciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Devoluciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Devoluciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
