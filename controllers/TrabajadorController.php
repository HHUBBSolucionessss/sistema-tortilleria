<?php

namespace app\controllers;

use Yii;
use app\models\Trabajador;
use app\models\TrabajadorSearch;
use app\models\RegistroSistema;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrabajadorController implements the CRUD actions for Trabajador model.
 */
class TrabajadorController extends Controller
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
     * Lists all Trabajador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrabajadorSearch();
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
     * Displays a single Trabajador model.
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
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado datos del trabajador ". $model->nombre;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $model->update_user=Yii::$app->user->identity->id;
          $model->update_time=date('Y-m-d H:i:s');

          $id_current_user = Yii::$app->user->identity->id;
          $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

          if($privilegio[0]['modificar_trabajador'] == 1){
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
     * Creates a new Trabajador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_trabajador'] == 1){
        $model = new Trabajador();
        $registroSistema = new RegistroSistema();

        if ($model->load(Yii::$app->request->post())) {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->sucursal_id = Yii::$app->user->identity->id_sucursal;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha registrado al trabajador ". $model->nombre;
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
     * Updates an existing Trabajador model.
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
     * Deletes an existing Trabajador model.
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

      if($privilegio[0]['eliminar_trabajador'] == 1){
        $registroSistema= new RegistroSistema();

        $model->eliminado = 1;
        $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado al trabajador ". $model->nombre;
        $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

        if($model->save() && $registroSistema->save()){
          Yii::$app->session->setFlash('kv-detail-success', 'El trabajador se ha eliminado correctamente');
          return $this->redirect(['index']);
        }
      }
      else{
        Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
        return $this->redirect(['view', 'id'=>$model->id]);
      }
    }

    /**
     * Finds the Trabajador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trabajador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trabajador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
