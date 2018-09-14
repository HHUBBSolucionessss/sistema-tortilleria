<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\CostalesSearch;
use yii\filters\VerbFilter;

/**
 * PrivilegioController implements the CRUD actions for Privilegio model.
 */
class CostalesController extends Controller
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
       $searchModel = new CostalesSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       return $this->render('index', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
     }
}
