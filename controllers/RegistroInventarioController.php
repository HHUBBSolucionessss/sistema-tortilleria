<?php

namespace app\controllers;

use Yii;
use app\models\RegistroInventario;
use app\models\RegistroInventarioDetallado;
use app\models\RegistroInventarioSearch;
use yii\web\Controller;
use app\models\RegistroSistema;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistroInventarioController implements the CRUD actions for RegistroInventario model.
 */
class RegistroInventarioController extends Controller
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
     * Lists all RegistroInventario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistroInventarioSearch();
        $id_current_user = Yii::$app->user->identity->id;

        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $totalBoveda = Yii::$app->db->createCommand('SELECT Sum(efectivo) FROM boveda AS Boveda')->queryAll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'privilegio'=>$privilegio,
            'totalBoveda'=>$totalBoveda,
        ]);
    }

    /**
     * Displays a single RegistroInventario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RegistroInventario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_proveedor'] == 1){
        $model = new RegistroInventario();
        $detallado = new RegistroInventarioDetallado();
        $registroSistema = new RegistroSistema();

        if ($model->load(Yii::$app->request->post()) && $detallado->load(Yii::$app->request->post())) {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = 1;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha hecho un registro en el inventario";
          $registroSistema->id_sucursal = 1;

          if($model->save() && $registroSistema->save())
          {
            $last_id = Yii::$app->db->createCommand('SELECT MAX(id) AS id FROM registro_inventario')->queryAll();
            $cant_anterior = Yii::$app->db->createCommand('SELECT cant FROM inventario WHERE id_producto = '. $detallado->id_producto)->queryAll();
            $detallado->id_registro = $last_id[0]['id'];
            $detallado->cantidad_anterior = $cant_anterior[0]['cant'];

            if($detallado->save()){
                return $this->redirect(['index']);
            }
          }
        }
      }
      else{
        return $this->redirect(['index']);
      }

      return $this->render('create', [
          'model' => $model,
      ]);
    }

    /**
     * Updates an existing RegistroInventario model.
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
     * Deletes an existing RegistroInventario model.
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
     * Finds the RegistroInventario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegistroInventario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistroInventario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
