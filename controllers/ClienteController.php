<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\ClienteSearch;
use app\models\RegistroSistema;
use app\models\VentaSearch;
use app\models\Venta;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClienteSearch();
        $id_current_user = Yii::$app->user->identity->id;

        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $totalCaja = Yii::$app->db->createCommand('SELECT Sum(efectivo), Sum(tarjeta), Sum(deposito) FROM caja AS Caja')->queryAll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalCaja'=>$totalCaja,
            'privilegio'=>$privilegio,
        ]);
    }

    /**
     * Displays a single Cliente model.
     * @param integer $id
     * @param integer $sucursal_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $registroSistema= new RegistroSistema();
      $searchModel = new VentaSearch();
      $searchModel2 = new VentaSearch();

      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider2 = $searchModel2->search2(Yii::$app->request->queryParams);
      $sumTotal=Yii::$app->db->createCommand('SELECT sum(total) FROM venta WHERE id_cliente ='.$model->id)->queryAll();

      if ($model->load(Yii::$app->request->post()))
      {
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado datos del cliente ". $model->nombre;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $model->update_user=Yii::$app->user->identity->id;
          $model->update_time=date('Y-m-d H:i:s');

          $id_current_user = Yii::$app->user->identity->id;
          $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

          if($privilegio[0]['modificar_cliente'] == 1){
            if ($model->save() && $registroSistema->save())
            {
                Yii::$app->session->setFlash('kv-detail-success', 'La información se actualizó correctamente');
                return $this->redirect(['view', 'id'=>$model->id]);
            }
            else
            {
                Yii::$app->session->setFlash('kv-detail-warning', 'Ha ocurrido un error al guardar la información');
                return $this->redirect(['view', 'id'=>$model->id]);
            }
          }
          else{
            Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
            return $this->redirect(['view', 'id'=>$model->id]);
          }
      }
      else
      {
          return $this->render('view', [
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sumTotal'=>$sumTotal,
            'model'=>$model,
          ]);

      }
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_cliente'] == 1){
        $model = new Cliente();
        $registroSistema = new RegistroSistema();

        if ($model->load(Yii::$app->request->post())) {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->sucursal_id = Yii::$app->user->identity->id_sucursal;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha registrado al cliente ". $model->nombre;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

          if($model->save() && $registroSistema->save())
          {
            return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $sucursal_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'sucursal_id' => $model->sucursal_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cliente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $sucursal_id
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
        $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado al cliente ". $model->nombre;
        $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

        if($model->save() && $registroSistema->save()){
          Yii::$app->session->setFlash('kv-detail-success', 'El cliente se ha eliminado correctamente');
          return $this->redirect(['index']);
        }
      }
      else{
        Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
        return $this->redirect(['view', 'id'=>$model->id]);
      }
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $sucursal_id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
