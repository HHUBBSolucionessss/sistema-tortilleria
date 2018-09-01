<?php

namespace app\controllers;

use Yii;
use app\models\Banco;
use app\models\RegistroSistema;
use app\models\BancoSearch;
use app\models\Privilegio;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BancoController implements the CRUD actions for Banco model.
 */
class BancoController extends Controller
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
     * Lists all Banco models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BancoSearch();
        $id_current_user = Yii::$app->user->identity->id;

        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $totalBanco = Yii::$app->db->createCommand('SELECT Sum(tarjeta), Sum(deposito) FROM banco AS Banco')->queryAll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalBanco'=>$totalBanco,
            'privilegio'=>$privilegio,
        ]);
    }

    /**
     * Displays a single Banco model.
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
     * Creates a new Banco model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      $id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['movimientos_deposito'] == 1){

        $model = new Banco();
        $registroSistema= new RegistroSistema();
        if ($model->load(Yii::$app->request->post()))
        {
          $totalBanco = Yii::$app->db->createCommand('SELECT Sum(tarjeta), Sum(deposito) FROM banco AS Banco')->queryAll();
          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = 1;
          $model->id_cuenta = 1;
          $model->tarjeta = 0.00;

          if($model->tipo_movimiento == 1){
            $model->deposito=-($model->deposito);
            $registroSistema->descripcion = Yii::$app->user->identity->nombre ." retiró $".-($model->deposito). ' del banco';
            $registroSistema->id_sucursal=1;
          }
          else{
            $model->deposito= $model->deposito;
            $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ingresó $".$model->deposito. ' al banco';
            $registroSistema->id_sucursal=1;
          }

            if($model->save() && $registroSistema->save())
            {
                  $searchModel = new BancoSearch();
                  $estado_caja = Yii::$app->db->createCommand('SELECT * FROM estado_caja WHERE id = 1')->queryAll();
                  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                  return $this->redirect(['index', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
                      'estado_caja' => $estado_caja,
                      'totalBanco'=>$totalBanco,
                  ]]);
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
     * Updates an existing Banco model.
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
     * Deletes an existing Banco model.
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
     * Finds the Banco model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banco the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banco::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
