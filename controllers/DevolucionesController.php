<?php

namespace app\controllers;

use Yii;
use app\models\Devoluciones;
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
     * Creates a new Devoluciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
       $id_current_user = Yii::$app->user->identity->id;
         $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

         if($privilegio[0]['apertura_caja'] == 1){
           $modelVenta = new Devoluciones;
           $registroSistema= new RegistroSistema();
           $ventaProductos = [new DevolucionDetallada];
           if ($modelVenta->load(Yii::$app->request->post()))
           {
               $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha hecho una devolución";
               $modelVenta->create_user=Yii::$app->user->identity->id;
               $modelVenta->id_sucursal = Yii::$app->user->identity->id_sucursal;
               $modelVenta->create_time=date('Y-m-d H:i:s');
               $registroSistema->save();
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
                           return $this->redirect(['view', 'id' => $modelVenta->id]);
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

      if($privilegio[0]['eliminar_cliente'] == 1){
        $registroSistema= new RegistroSistema();

        $model->eliminado = 1;
        $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado la devolución ". $model->id;
        $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

        if($model->save() && $registroSistema->save()){
          Yii::$app->session->setFlash('kv-detail-success', 'La devolución se ha eliminado correctamente');
          return $this->redirect(['index']);
        }
      }
      else{
        Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
        return $this->redirect(['view', 'id'=>$model->id]);
      }
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
