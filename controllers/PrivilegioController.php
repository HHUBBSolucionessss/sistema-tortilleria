<?php

namespace app\controllers;

use Yii;
use app\models\Privilegio;
use app\models\Habitacion;
use app\models\PrivilegioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrivilegioController implements the CRUD actions for Privilegio model.
 */
class PrivilegioController extends Controller
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
     * Lists all Privilegio models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new PrivilegioSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }

    /**
     * Updates an existing Privilegio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionUpdate($id)
     {
         $id_current_user = Yii::$app->user->identity->id;
         $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

         if($privilegio[0]['definir_privilegios'] == 1){
           $idPrivilegio = Yii::$app->db->createCommand('SELECT id FROM privilegio WHERE id_usuario='.$id)->queryOne();
           $model = $this->findModel($idPrivilegio);
           if ($model->load(Yii::$app->request->post()) && $model->save()) {
               return $this->redirect(['registrar-usuario/view', 'id' => $id]);
           }
         }
         else{
           return $this->redirect(['../web/site/index']);
         }

         return $this->render('update', [
             'model' => $model,
         ]);
     }

    /**
     * Deletes an existing Privilegio model.
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
     * Finds the Privilegio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Privilegio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Privilegio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
