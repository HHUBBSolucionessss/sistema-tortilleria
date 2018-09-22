<?php

namespace app\controllers;

use Yii;
use app\models\Cuenta;
use app\models\CuentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\RegistroSistema;
use yii\filters\VerbFilter;

/**
 * CuentaController implements the CRUD actions for Cuenta model.
 */
class CuentaController extends Controller
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
     * Lists all Cuenta models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new CuentaSearch();
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
     * Displays a single Cuenta model.
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
           $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado datos de la cuenta ". $model->nombre;
           $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

           $id_current_user = Yii::$app->user->identity->id;
           $privilegio = Yii::$app->db->createCommand('SELECT modificar_cuenta FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

           if($privilegio[0]['modificar_cuenta'] == 1){
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
     * Creates a new Cuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
       $id_current_user = Yii::$app->user->identity->id;
       $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

       if($privilegio[0]['crear_cuenta'] == 1){
         $model = new Cuenta();
         $registroSistema = new RegistroSistema();

         if ($model->load(Yii::$app->request->post())) {

           $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha creado la cuenta ". $model->nombre;
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
     * Deletes an existing Cuenta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDelete($id)
     {
       $model = $this->findModel($id);
       $id_current_user = Yii::$app->user->identity->id;
       $privilegio = Yii::$app->db->createCommand('SELECT eliminar_cuenta FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

       if($privilegio[0]['eliminar_cuenta'] == 1){
         $registroSistema= new RegistroSistema();

         $model->eliminado = 1;
         $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado la cuenta ". $model->nombre;
         $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

         if($model->save() && $registroSistema->save()){
           Yii::$app->session->setFlash('kv-detail-success', 'La cuenta se ha eliminado correctamente');
           return $this->redirect(['index']);
         }
       }
       else{
         Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
         return $this->redirect(['view', 'id'=>$model->id]);
       }
     }

    /**
     * Finds the Cuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cuenta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
