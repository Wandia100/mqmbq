<?php

namespace app\controllers;

use Yii;
use app\models\StationManagementStations;
use app\models\StationManagementStationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;
use yii\db\IntegrityException;
/**
 * StationmanagementstationsController implements the CRUD actions for StationManagementStations model.
 */
class StationmanagementstationsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->isGuest){
                                return TRUE;
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
     * Lists all StationManagementStations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StationManagementStationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StationManagementStations model.
     * @param string $id
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
     * Creates a new StationManagementStations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StationManagementStations();

        if ($model->load(Yii::$app->request->post())) {
            try{
                $model->id=Uuid::generate()->string;
                $model->unique_field=$model->station_id.$model->station_management_id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->save(false);
                $act = new \app\models\ActivityLog();
                $act -> desc = "S.M.S create";
                $act -> propts = "'{id:$model->id }'";
                $act ->setLog();
                //return $this->redirect(['view', 'id' => $model->id]);
                return $this->redirect(['index']);
            }
            catch(IntegrityException $e)
            {
                //do nothing
                return $this->redirect(['index']);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StationManagementStations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at=date('Y-m-d H:i:s');
            $model->save();
            $act = new \app\models\ActivityLog();
            $act -> desc = "S.M.S update";
            $act -> propts = "'{id:$model->id }'";
            $act ->setLog();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StationManagementStations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StationManagementStations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StationManagementStations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StationManagementStations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
