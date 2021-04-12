<?php

namespace app\controllers;

use Yii;
use app\models\StationShows;
use app\models\StationShowsSearch;
use app\models\StationShowPresenters;
use app\models\StationShowPresentersSearch;
use app\models\StationShowPrizes;
use app\models\StationShowPrizesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;

/**
 * StationshowsController implements the CRUD actions for StationShows model.
 */
class StationshowsController extends Controller
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
                        'actions' => ['create', 'update','index','addpresenter','addprize'],
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
     * Lists all StationShows models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StationShowsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StationShows model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new StationShowPresentersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
        
        $prizeSearchModel = new StationShowPrizesSearch();
        $prizeDataProvider = $prizeSearchModel->search(Yii::$app->request->queryParams,$id);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prizeSearchModel'=>$prizeSearchModel,
            'prizeDataProvider'=>$prizeDataProvider
        ]);
    }
    /**
     * 
     */
    public function actionAddpresenter($id){
        $model = $this->findModel($id);
        $ShowPresenter = new StationShowPresenters();
        $ShowPresenter->id=Uuid::generate()->string;
        $ShowPresenter -> station_id = $model->stations->id;
        $ShowPresenter -> station_show_id = $id;
        $ShowPresenter->presenter_id = $_POST['presenter_id'];
        $ShowPresenter->created_at = date('Y-m-d H:i:s');
        $ShowPresenter->save();
        return $this->redirect(['view', 'id' => $id]);
    }
    /**
     * 
     */
    public function actionAddprize($id){
        $model = $this->findModel($id);
        if($_POST['showprizeid'] == ""):
            $ShowPrize = new StationShowPrizes();
            $ShowPrize->id=Uuid::generate()->string;
        else :
            $ShowPrize = StationShowPrizes::findOne($_POST['showprizeid']);
        endif;
        
        $ShowPrize -> station_id = $model->stations->id;
        $ShowPrize -> station_show_id = $id;
        $ShowPrize->draw_count = $_POST['draw_count'];
        $ShowPrize->monday = $_POST['monday'];
        $ShowPrize->tuesday = $_POST['tuesday'];
        $ShowPrize->wednesday = $_POST['wednesday'];
        $ShowPrize->thursday = $_POST['thursday'];
        $ShowPrize->friday = $_POST['friday'];
        $ShowPrize->saturday = $_POST['saturday'];
        $ShowPrize->sunday = $_POST['sunday'];
        $ShowPrize->enabled = $_POST['enabled'];
        $ShowPrize->created_at = date('Y-m-d H:i:s');
        $ShowPrize->save();
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new StationShows model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StationShows();

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->id=Uuid::generate()->string;
            $model->created_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StationShows model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing StationShows model.
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
     * Finds the StationShows model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StationShows the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StationShows::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
