<?php

namespace app\controllers;

use Yii;
use app\models\TransactionHistories;
use app\models\StationShowPresenters;
use app\models\Users;
use app\models\WinningHistories;
use app\models\MpesaPayments;
use app\models\Disbursements;
use app\models\StationShowPrizes;
use app\models\TransactionHistoriesSearch;
use app\models\ProcessedMpesaPayments;
use app\models\StationShows;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Myhelper;
use Webpatser\Uuid\Uuid;

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
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);

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
            $target_achievement=round(($transaction_total/$presenter_station_show['target'])*100,2);
            $show_name=$presenter_station_show['show_name']." ".$presenter_station_show['start_time']." - ".$presenter_station_show['end_time'];
            $recent_winners=WinningHistories::getRecentWinners($presenter_station_show['station_show_id'],date("Y-m-d"));
            $show_prizes=StationShowPrizes::getShowPrizes(strtolower(date("l")),$presenter_station_show['station_show_id']);
            $percent_raised=round(($transaction_total/$presenter_station_show['target'])*100,2);
            $percent_pending=round((($presenter_station_show['target']-$transaction_total)/$presenter_station_show['target'])*100,2);
        }
        else
        {
            $transaction_total=0;
            $transaction_count=0;
            $target_achievement=0;
            $show_name="No draw at this moment";
            $recent_winners=array();
            $show_prizes=array();
            $percent_raised=0;
            $percent_pending=0;
        }
        //echo json_encode($show_prizes); exit();
        
        return $this->render('presenter', [
            'show_name' => $show_name,
            'transaction_total' => $transaction_total,
            'transaction_count' => $transaction_count,
            'target_achievement' => $target_achievement,
            'presenter_station_show' => $presenter_station_show,
            'recent_winners' => $recent_winners,
            'show_prizes' => $show_prizes,
            'percent_raised' => $percent_raised,
            'percent_pending' => $percent_pending
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
    public function actionAssignshows()
    {
        $data=MpesaPayments::find()->where("state=0")->all();
        for($i=0;$i<count($data); $i++)
        {
            $row=$data[$i];
            //check if amount > 300 and refund after deducting 100
            if($row->TransAmount > 300)
            {
                $refund=$row->TransAmount-100;
                Disbursements::saveDisbursement($row->id,$row->FirstName.$row->LastName,$row->MSISDN,$refund,"winning");
                $row->deleted_at=date("Y-m-d H:i:s");
                $row->save(false);
                return;
            }
            $station_show=StationShows::getStationShow($row->BillRefNumber);
            if($station_show!=NULL)
            {
                $model=new TransactionHistories();
                $model->id=Uuid::generate()->string;
                $model->mpesa_payment_id=$row->id;
                $model->reference_name=$row->FirstName.$row->MiddleName.$row->LastName;
                $model->reference_phone=$row->MSISDN;
                $model->reference_code=$row->BillRefNumber;
                $model->station_id=$station_show['station_id'];
                $model->station_show_id=$station_show['show_id'];
                $model->amount=$row->TransAmount;
                $model->created_at=date("Y-m-d H:i:s");
                $model->save(false);
                $row->state=1;
                $row->save(false);
            }
            
        }
    }
}
