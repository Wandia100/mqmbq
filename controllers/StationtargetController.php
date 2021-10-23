<?php

namespace app\controllers;

use Yii;
use app\models\StationTarget;
use app\models\StationTargetSearch;
use app\models\StationTargetLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

/**
 * StationtargetController implements the CRUD actions for StationTarget model.
 */
class StationtargetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','report'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index','report'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->isGuest){
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(29) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StationTarget models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StationTargetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReport()
    {
        $searchModel = new StationTargetLogSearch();
        $dataProvider =Yii::$app->myhelper->getdataprovider($searchModel);

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionLogtarget()
    {
        
        $hour_date=date("Y-m-d");
        //$hour=date("H");
        $hour=date("H", strtotime ("-1 hour"));
        StationTarget::setTargetLog($hour,$hour_date);
    }

    /**
     * Displays a single StationTarget model.
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
     * Creates a new StationTarget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StationTarget();

        if ($model->load(Yii::$app->request->post())) {
            $model->unique_field=$model->station_id.$model->start_time;
            try
            {
                if($model->save())
                {
                    return $this->redirect(['index']);
                }
            }
            catch(IntegrityException $e)
            {
                //do nothing
            }
           
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StationTarget model.
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
     * Deletes an existing StationTarget model.
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
     * Finds the StationTarget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StationTarget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StationTarget::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
