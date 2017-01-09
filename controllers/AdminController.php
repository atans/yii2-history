<?php

namespace atans\history\controllers;

use atans\history\Module;
use Yii;
use atans\history\models\History;
use atans\history\models\HistorySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for History model.
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        /* @var $module \atans\history\Module */
        $module = Module::getInstance();

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $module->adminRoles,
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all History models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /* @var $module Module */
        $module = Module::getInstance();

        return $this->render('index', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'usernameAttribute' => $module->usernameAttribute,
        ]);
    }

    /**
     * Displays a single History model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /* @var $module Module */
        $module = Module::getInstance();

        return $this->render('view', [
            'model'             => $this->findModel($id),
            'usernameAttribute' => $module->usernameAttribute,
        ]);
    }

    /**
     * Finds the History model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return History the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = History::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
