<?php

namespace app\controllers;

use Yii;
use app\models\Producto;
use app\models\Inventario;
use app\models\ProductoSearch;
use app\models\RegistroSistema;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
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
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoSearch();
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
     * Displays a single Producto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $registroSistema= new RegistroSistema();
      if ($model->load(Yii::$app->request->post()))
      {
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado datos del producto ". $model->nombre;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $model->update_user=Yii::$app->user->identity->id;
          $model->update_time=date('Y-m-d H:i:s');

          $id_current_user = Yii::$app->user->identity->id;
          $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

          if($privilegio[0]['modificar_producto'] == 1){
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
          return $this->render('view', ['model'=>$model]);

      }
    }

    /**
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_producto'] == 1){
        $model = new Producto();
        $registroSistema = new RegistroSistema();
        $inventario = new Inventario();

        if ($model->load(Yii::$app->request->post())) {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha registrado el producto ". $model->nombre;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $inventario->id_producto = $model->id;
          $inventario->id_sucursal = Yii::$app->user->identity->id_sucursal;

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
     * Updates an existing Producto model.
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
     * Deletes an existing Producto model.
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

      if($privilegio[0]['eliminar_producto'] == 1){
        $registroSistema= new RegistroSistema();

        $model->eliminado = 1;
        $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado el producto ". $model->nombre;
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
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
