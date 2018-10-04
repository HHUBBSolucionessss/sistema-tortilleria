<?php

namespace app\controllers;

use Yii;
use app\models\Nomina;
use app\models\Caja;
use app\models\NominaSearch;
use yii\web\Controller;
use app\models\RegistroSistema;
use app\models\Trabajador;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NominaController implements the CRUD actions for Nomina model.
 */
class NominaController extends Controller
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
            [
				'class' =>  'yii\filters\ContentNegotiator',
				'only' => ['obtener-sueldo'],
				'formats' => [
					'application/html' => Response::FORMAT_HTML,
				],
				'languages' => [
					'es',
				],
			],
        ];
    }

    /**
     * Lists all Nomina models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NominaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nomina model.
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
     * Creates a new Nomina model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $id_current_sucursal = Yii::$app->user->identity->id_sucursal;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['crear_nomina'] == 1)
      {
        $model = new Nomina();
        $caja = new Caja();
        $registroSistema = new RegistroSistema();

        $model->totalCaja = Yii::$app->db->createCommand('SELECT SUM(efectivo) AS efectivo FROM caja WHERE id_sucursal ='. $id_current_sucursal)->queryAll();

        if ($model->load(Yii::$app->request->post()))
        {

          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = Yii::$app->user->identity->id_sucursal;
          $registroSistema->descripcion = Yii::$app->user->identity->nombre ." realizó un pago de Nómina por la cantidad de $".$model->total;
          $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

          if($model->save() && $registroSistema->save())
          {

            $ultimaNomina = Yii::$app->db->createCommand('SELECT MAX(id) FROM nomina')->queryAll();

            //CAJA
            $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
            $caja->descripcion="Pago de nómina con folio ".$ultimaNomina[0]['MAX(id)'];
            $caja->efectivo=-$model->total;
            $caja->tipo_movimiento=1;
            $caja->tipo_pago=0;
            $caja->create_user=Yii::$app->user->identity->id;
            $caja->create_time=date('Y-m-d H:i:s');

            if($caja->save())

            return $this->redirect(['view', 'id' => $model->id]);
          }
        }
      }
      else{
        return $this->redirect(['index']);
      }

      return $this->render('create', [
          'model' => $model
      ]);
    }

    /**
     * Updates an existing Nomina model.
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
     * Deletes an existing Nomina model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDelete($id)
     {
         $model = $this->findModel($id);
         Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
         return $this->redirect(['view', 'id'=>$model->id]);
     }





     public function actionObtenerSueldo()
     {
         $model=Trabajador::find()->where(['id' => Yii::$app->request->post('id_trabajador')])->one();
         return $model->sueldo;
     }





     public function actionCancelar($id)
     {
       $model = $this->findModel($id);
       $id_current_user = Yii::$app->user->identity->id;
       $privilegio = Yii::$app->db->createCommand('SELECT cancelar_nomina FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

       if($privilegio[0]['cancelar_nomina'] == 1){
         $registroSistema= new RegistroSistema();

         $nomina = new Nomina();
         $nomina = Nomina::find()
         ->where(['id' => $id])
         ->one();

         $caja = new Caja();

         //CAJA
         $caja->id_sucursal=Yii::$app->user->identity->id_sucursal;
         $caja->descripcion="Cancelación de nómina con folio ".$id;
         $caja->efectivo=$nomina->total;
         $caja->tipo_movimiento=0;
         $caja->tipo_pago=0;
         $caja->create_user=Yii::$app->user->identity->id;
         $caja->create_time=date('Y-m-d H:i:s');

         $model->eliminado = 1;
         $registroSistema->descripcion = Yii::$app->user->identity->nombre ." canceló la nómina con folio: ".$model->id. ". Se sumaron $". $nomina->total. " a la caja.";
         $registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;

         if($model->save() && $registroSistema->save() && $caja->save()){
           Yii::$app->session->setFlash('kv-detail-success', 'La nómina ha sido cancelada');
           return $this->redirect(['index']);
         }
       }
       else{
         Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
         return $this->redirect(['view', 'id'=>$model->id]);
       }
     }



    /**
     * Finds the Nomina model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nomina the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nomina::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
