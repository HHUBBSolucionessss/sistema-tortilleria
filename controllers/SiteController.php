<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Sucursal;
use app\models\Reservacion;
use app\models\ReservacionSearch;
use app\models\RegistroSistema;
use app\models\RegistroSistemaSearch;
use yii\helpers\Json;

use app\models\User;


class SiteController extends Controller
{

	/**
	* @inheritdoc
	     */
	    public function behaviors()
	    {
		return [
		            'access' => [
		                'class' => AccessControl::className(),
		                'only' => ['logout','index'],
		                'rules' => [
		                    [
		                        'actions' => ['logout','index'],
		                        'allow' => true,
		                        'roles' => ['@'],
		                    ],
		                ],
		            ],
		            'verbs' => [
		                'class' => VerbFilter::className(),
		                'actions' => [
		                    'logout' => ['post'],
		                ],
		            ],
		        ];
	}


	/**
	* @inheritdoc
	     */
	    public function actions()
	    {
		return [
		            'error' => [
		                'class' => 'yii\web\ErrorAction',
		            ],
		            'captcha' => [
		                'class' => 'yii\captcha\CaptchaAction',
		                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
		            ],
		        ];
	}


	/**
	* Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$id_current_user = Yii::$app->user->identity->id;
		$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

		return $this->render('index', [
				'privilegio'=>$privilegio,
		]);
	}

	/**
	* Login action.
	     *
	     * @return Response|string
	     */
	    public function actionLogin()
	    {
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {

			$id_current_user = Yii::$app->user->identity->id;
			//$tipo_usuario = Yii::$app->db->createCommand('SELECT id_sucursal FROM usuario WHERE id= '.$id_current_user)->queryOne();
			$privilegio = Yii::$app->db->createCommand('SELECT * FROM privilegio WHERE id_usuario = '.$id_current_user)->queryAll();

				return $this->render('index', [
				            'model' => $model,
										'privilegio'=>$privilegio,
				        ]);


		}
		return $this->render('login', [
		            'model' => $model,
		        ]);
	}


	/**
	* Logout action.
	     *
	     * @return Response
	     */
	    public function actionLogout()
	    {
		Yii::$app->user->logout();

		return $this->goHome();
	}


	/**
	* Displays contact page.
	     *
	     * @return Response|string
	     */
	    public function actionContact()
	    {
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
		            'model' => $model,
		        ]);
	}


	/**
	* Displays about page.
	     *
	     * @return string
	     */
	    public function actionAbout()
	    {
		return $this->render('about');
	}


	/**
	* Displays a single Reservacion model.
	* @param integer $id
	* @return mixed
	*/
	public function actionView($id)
	{
		$searchModel = new ReservacionSearch();
		$dataProvider = $searchModel->buscarPagos(Yii::$app->request->queryParams);
		return $this->render('/reservacion/view', [
		'model' => $this->findModelReservacion($id),
		'dataProvider'=>$dataProvider
		]);
	}
	/**
	* Finds the Reservacion model based on its primary key value.
	* If the model is not found, a 404 HTTP exception will be thrown.
	* @param integer $id
	* @return Reservacion the loaded model
	* @throws NotFoundHttpException if the model cannot be found
	*/
	protected function findModelReservacion($id)
	{
		if (($model = Reservacion::findOne($id)) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('The requested page does not exist.');
	}



	public function actionRegistro()
    {
        $searchModel = new RegistroSistemaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('registro', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}



}
