<?php

namespace app\controllers;

use Yii;
use app\models\TransactionHistories;
use app\models\StationShowPresenters;
use app\models\Users;
use app\models\WinningHistories;
use app\models\TransactionHistoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Myhelper;
/**
 * TransactionhistoriesController implements the CRUD actions for TransactionHistories model.
 */
class TransactionhistoriesController extends Controller
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
     * Lists all TransactionHistories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionHistoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransactionHistories model.
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
     * Creates a new TransactionHistories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TransactionHistories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TransactionHistories model.
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
     * Deletes an existing TransactionHistories model.
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
    public function actionPresenter()
    {
        $presenter=Yii::$app->user->identity;
        $presenter_station_show=StationShowPresenters::presenterStationShow($presenter->id,date("H"),strtolower(date("l")));
        if($presenter_station_show)
        {
            $station_show_id=$presenter_station_show['station_show_id'];
            $start_time=date("Y-m-d")." ".$presenter_station_show['start_time'];
            $end_time=date("Y-m-d")." ".$presenter_station_show['end_time'];
            $show_transactions=TransactionHistories::getShowTransactions($station_show_id,$start_time,$end_time);
            $transaction_total=TransactionHistories::getTransactionTotal($station_show_id,$start_time,$end_time)['total'];
            $transaction_count=count($show_transactions);
            $target_achievement=($transaction_total/$presenter_station_show['target'])*100;
            $show_name=$presenter_station_show['show_name']." ".$presenter_station_show['start_time']." - ".$presenter_station_show['end_time'];
            $recent_winners=WinningHistories::getRecentWinners($presenter_station_show['station_show_id'],date("Y-m-d"));
        }
        else
        {
            $transaction_total=0;
            $transaction_count=0;
            $target_achievement=0;
            $show_name="No draw at this moment";
            $recent_winners=array();
        }
        
        return $this->render('presenter', [
            'show_name' => $show_name,
            'transaction_total' => $transaction_total,
            'transaction_count' => $transaction_count,
            'target_achievement' => $target_achievement,
            'recent_winners' => $recent_winners
        ]);
    }

    /**
     * Finds the TransactionHistories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TransactionHistories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransactionHistories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
