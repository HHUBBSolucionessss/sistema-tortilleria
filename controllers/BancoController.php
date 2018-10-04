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
        $id_sucursal = Yii::$app->user->identity->id_sucursal;

        $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
        $totalBanco = Yii::$app->db->createCommand('SELECT Sum(deposito) FROM banco AS Banco WHERE id_sucursal = '. $id_sucursal)->queryAll();
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
      $id_sucursal = Yii::$app->user->identity->id_sucursal;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['movimientos_deposito'] == 1){

        $model = new Banco();
        $registroSistema= new RegistroSistema();
        $model->id_sucursal = Yii::$app->user->identity->id_sucursal;

        if ($model->load(Yii::$app->request->post()))
        {
          $totalBanco = Yii::$app->db->createCommand('SELECT Sum(deposito) FROM banco AS Banco')->queryAll();
          $model->create_user=Yii::$app->user->identity->id;
          $model->create_time=date('Y-m-d H:i:s');
          $model->id_sucursal = Yii::$app->user->identity->id_sucursal;

          if($model->tipo_movimiento == 1){
            $model->deposito=-($model->deposito);
            $registroSistema->descripcion = Yii::$app->user->identity->nombre ." retiró $".-($model->deposito). ' del banco';
            $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;
          }
          else{
            $model->deposito= $model->deposito;
            $registroSistema->descripcion = Yii::$app->user->identity->nombre ." ingresó $".$model->deposito. ' al banco';
            $registroSistema->id_sucursal=Yii::$app->user->identity->id_sucursal;
          }

            if($model->save() && $registroSistema->save())
            {
                  $searchModel = new BancoSearch();
                  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                  return $this->redirect(['index', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
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
