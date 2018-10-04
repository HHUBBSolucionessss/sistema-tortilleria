<?php

namespace app\controllers;


use Yii;

use app\models\User;
use app\models\Privilegio;
use app\models\Sucursal;
use app\models\PrivilegioSearch;
use app\models\UsuarioSearch;
use app\models\RegistroSistema;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SignupForm;
use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;

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
		$id_current_user = Yii::$app->user->identity->id;
		$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

		return $this->render('index', [
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'privilegio'=>$privilegio,
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
			$registroSistema->id_sucursal = Yii::$app->user->identity->id_sucursal;
			$id_current_user = Yii::$app->user->identity->id;
			$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

			if($privilegio[0]['modificar_usuario'] == 1){
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
			$id_current_user = Yii::$app->user->identity->id;
			$sucursal_actual = Yii::$app->user->identity->id_sucursal;
			$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();
			$modelSucursal = new Sucursal();
			$usuario = new User();

			if($privilegio[0]['crear_usuario'] == 1){
				$model = new SignupForm();
				$privilegio= new Privilegio();
				$registroSistema= new RegistroSistema();

				if ($model->load(Yii::$app->request->post()))
				{

					$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha registrado al usuario ". $model->nombre;
					$registroSistema->id_sucursal=1;
					$model->id_sucursal = $sucursal_actual;

					$temporal = $model->temp;

					if ($model->signup())
					{

						$user_created = User::findOne(['email' => $model->email]);

						$id = $user_created->id;
						$user_created->temp = $temporal;
						$user_created->create_user=$id_current_user;
						$user_created->password_reset_token = $user_created->password_hash;
						$privilegio->id_usuario = $id;
						$privilegio->movimientos_caja=1;
						$privilegio->apertura_caja=1;
						$privilegio->cierre_caja=1;

						if($privilegio->save() && $registroSistema->save() && $user_created->save()){
							return $this->redirect(['index']);
						}

					}

				}
			}
			else{
				return $this->redirect(['index']);
			}

				return $this->renderAjax('create', [
				'model' => $model,
				'modelSucursal' => $modelSucursal,
				'usuario' => $usuario,
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
			$id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

      if($privilegio[0]['eliminar_usuario'] == 1){
		 		$registroSistema= new RegistroSistema();

		 		$model->eliminado = 1;
		 		$registroSistema->descripcion = Yii::$app->user->identity->nombre ." ha eliminado al usuario ". $model->nombre;
				$registroSistema->id_sucursal=1;

      if($model->save() && $registroSistema->save()){
					Yii::$app->session->setFlash('kv-detail-success', 'El usuario se ha eliminado correctamente');
   				return $this->redirect(['index']);
   			}
      }
      else{
        Yii::$app->session->setFlash('kv-detail-warning', 'No tienes los permisos para realizar esta acción');
        return $this->redirect(['view', 'id'=>$model->id]);
      }
	 	}

		public function actionResetpass($id)
		{
			$model = $this->findModel($id);
			$user = new User();
			$searchModel = new UsuarioSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$id_current_user = Yii::$app->user->identity->id;
      $privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

			if($privilegio[0]['modificar_usuario'] == 1){

			if ($searchModel->load(Yii::$app->request->post()))
			{

				$model->password_hash = $searchModel->password_reset_token;

				$model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);

				if($model->save()){

					return $this->redirect(['view', 'id'=>$model->id]);

						}
					}
				else{
					return $this->render('resetpass', [
					'model' => $model,
					'user' => $user,
					'searchModel' => $searchModel,
					'dataProvider' => $dataProvider,
					]);
				}
			}
			else{
				return $this->redirect(['index']);
			}
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
