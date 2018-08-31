<?php

namespace app\controllers;


use Yii;

use app\models\User;
//use app\models\Privilegio;
use app\models\UsuarioSearch;
use app\models\RegistroSistema;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SignupForm;



/**
 * UserController implements the CRUD actions for User model.
 */

class RegistrarUsuarioController extends Controller
{


	/**
     * @inheritdoc
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
     * Lists all User models.
     * @return mixed
     */

	public function actionIndex()
	{

		$searchModel = new UsuarioSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$id_current_user = Yii::$app->user->identity->id;
		//$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

		return $this->render('index', [
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		//'privilegio'=>$privilegio,
		]);

	}



	/**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */

	public function actionView($id)
	{
		$id_current_user = Yii::$app->user->identity->id;
		$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
		$model = $this->findModel($id);
		$registroSistema= new RegistroSistema();
		$idUsuario = Yii::$app->db->createCommand('SELECT id FROM privilegio WHERE id_usuario='.$id)->queryOne();
		if ($model->load(Yii::$app->request->post()))
		{
			$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha actualizado datos del usuario ". $model->nombre;
			$id_current_user = Yii::$app->user->identity->id;
			$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

			if($privilegio[0]['apertura_caja'] == 1){
				if ($model->save() && $registroSistema->save())
				{
					Yii::$app->session->setFlash('kv-detail-success', 'La información se actualizó correctamente');
					return $this->redirect(['view', 'id'=>$model->id,
					'idUsuario' => $idUsuario,
					'model'=>$model,
				]);
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
				'model'=>$model,
				'privilegio'=>$privilegio,
			]);
		}
	}

	/**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

	public function actionCreate()
	{
			/*$id_current_user = Yii::$app->user->identity->id;
			$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

			if($privilegio[0]['crear_usuario'] == 1){*/
				$model = new SignupForm();
				$usuario = new User();
				/*$privilegio= new Privilegio();
				$registroSistema= new RegistroSistema();*/

				if ($model->load(Yii::$app->request->post()))
				{

					//$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha registrado al usuario ". $model->nombre;

					if ($model->signup())
					{

						/*$sql = User::findOne(['email' => $model->email]);

						$id = $sql->id;
						$privilegio->id_usuario = $id;
						$privilegio->crear_habitacion=1;
						$privilegio->modificar_habitacion=1;
						$privilegio->eliminar_habitacion=1;
						$privilegio->crear_tipo_habitacion=1;
						$privilegio->modificar_tipo_habitacion=1;
						$privilegio->eliminar_tipo_habitacion=1;
						$privilegio->movimientos_caja=1;
						$privilegio->apertura_caja=1;
						$privilegio->cierre_caja=1;
						$privilegio->crear_reservacion=1;
						$privilegio->modificar_reservacion=1;
						$privilegio->eliminar_reservacion=1;*/

						/*if($privilegio->save() && $registroSistema->save()){*/
							return $this->redirect(['index']);
						//}

					}

				}
			/*}
			else{
				return $this->redirect(['index']);
			}*/

				return $this->renderAjax('create', [
				'model' => $model,
				]);



	}




	/**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

	public function actionUpdate($id)
	{

		$model = $this->findModel($id);

		//$model->create_user=Yii::$app->user->identity->id;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {

			return $this->redirect(['index', 'id' => $model->id]);

		}


		return $this->render('update', [
		'model' => $model,
		]);

	}



	/**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

		 public function actionDelete($id)
	 	{

	 		$model = $this->findModel($id);
			/*$id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['eliminar_usuario'] == 1){
		 		$registroSistema= new RegistroSistema();

		 		$model->eliminado = 1;
		 		$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado al usuario ". $model->nombre;*/

      if($model->save() /*&& $registroSistema->save()*/){
					//Yii::$app->session->setFlash('kv-detail-success', 'El usuario se ha eliminado correctamente');
   				return $this->redirect(['index']);
   			}
      /*}
      else{
        Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');*/
        return $this->redirect(['view', 'id'=>$model->id]);
      //}
	 	}



	/**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

	protected function findModel($id)
	{

		if (($model = User::findOne($id)) !== null) {

			return $model;

		}


		throw new NotFoundHttpException('The requested page does not exist.');

	}

}
