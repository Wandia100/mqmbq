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
use yii\db\IntegrityException;

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
                'only' => ['create', 'update','index','presenter','admindraws'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(23) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['presenter'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(39) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['admindraws'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(41) );
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
        $presenter_station_show=StationShowPresenters::presenterStationShow($presenter->id,strtolower(date("l")));
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
            $show_prizes=StationShowPrizes::getShowPrizes(strtolower(date("l")),$presenter_station_show['station_show_id'],date("Y-m-d"));
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
        
        $act = new \app\models\ActivityLog();
        $act -> desc = "Presenters page";
        $act ->setLog();
        
        return $this->render('presenter', [
            'from' => date("Y-m-d"),
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
    public function actionAdmindraws($show_id="",$from="")
    {
        //$presenter=Yii::$app->user->identity;
        $presenter=[];
        $presenter_station_show=[];
        $shows=StationShows::getStationShows();
        if(!empty($show_id) && !empty($from))
        {
            //$presenter=StationShowPresenters::getShowAdmin($show_id);
            $presenter_station_show=StationShowPresenters::adminStationShow($show_id,strtolower(date("l",strtotime($from))));
        }
        if(!empty($presenter_station_show))
        {
            $station_show_id=$presenter_station_show['station_show_id'];
            $start_time=$from." ".$presenter_station_show['start_time'];
            $end_time=$from." ".$presenter_station_show['end_time'];
            $show_transactions=TransactionHistories::getShowTransactions($station_show_id,$start_time,$end_time);
            $transaction_total=TransactionHistories::getTransactionTotal($station_show_id,$start_time,$end_time)['total'];
            $transaction_count=count($show_transactions);
            $target_achievement=round(($transaction_total/$presenter_station_show['target'])*100,2);
            $show_name=$presenter_station_show['show_name']." ".$presenter_station_show['start_time']." - ".$presenter_station_show['end_time'];
            $recent_winners=WinningHistories::getRecentWinners($presenter_station_show['station_show_id'],$from);
            $show_prizes=StationShowPrizes::getShowPrizes(strtolower(date("l",strtotime($from))),$presenter_station_show['station_show_id'],$from);
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
        
        $act = new \app\models\ActivityLog();
        $act -> desc = "Admin Draws";
        $act ->setLog();
        
        return $this->render('admin_draws', [
            'show_id' => $show_id,
            'from' => $from,
            'shows' => $shows,
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
        //Myhelper::checkRemoteAddress();
        $hostname = gethostname(); //
        if (in_array($hostname, COTZ))
        {
            $play_min=1000;
            $play_max=2000;
        }
        else
        {
            $play_min=100;
            $play_max=300;
        }

        $data=MpesaPayments::find()->where("state=0")->all();
        for($i=0;$i<count($data); $i++)
        {
            $row=$data[$i];
            //check if amount > 300 and refund after deducting 100
            if($row->TransAmount <$play_min)
            {
                //do nothing
                $row->state=1;
                $row->save(false);
                Myhelper::setSms('invalidDrawAmount',$row->MSISDN,[$row->FirstName],NULL);
            }
            else if($row->TransAmount >= $play_min && $row->TransAmount < $play_max)
            {
                if (in_array($hostname,[COMP21_NET]) && strlen($row->BillRefNumber)==1 && strtolower($row->BillRefNumber)=='j') {
                    $station_show=StationShows::getStationShowNet($row->BillRefNumber);
                }
                else
                {
                    $station_show=StationShows::getStationShow($row->BillRefNumber);
                }
                if($station_show!=NULL)
                {
                    try 
                    {
                        $model=new TransactionHistories();
                        $model->id=Uuid::generate()->string;
                        $model->mpesa_payment_id=$row->id;
                        $model->reference_name=$row->FirstName." ".$row->MiddleName." ".$row->LastName;
                        $model->reference_phone=$row->MSISDN;
                        $model->reference_code=$row->BillRefNumber;
                        $model->station_id=$station_show['station_id'];
                        $model->station_show_id=$station_show['show_id'];
                        $model->amount=$row->TransAmount;
                        $model->created_at=$row->created_at;
                        $model->save(false);
                        $row->state=1;
                        $row->save(false);
                        if(in_array($hostname,COTZ))
                        {
                            $totalEntry=TransactionHistories::countEntry($row->MSISDN);
                            $entryNumber=TransactionHistories::generateEntryNumber($row->MSISDN,$totalEntry);
                            Myhelper::setSms('validDrawEntry',$row->MSISDN,['Habari',$entryNumber,$totalEntry],$station_show['station_id']);
                        }
                        else
                        {
                            Myhelper::setSms('validDraw',$row->MSISDN,[$row->FirstName],$station_show['station_id']);
                        }

                    }
                    catch (IntegrityException $e) {
                        //allow execution
                    }
                    
                }
               
            }
            else{
                if($row->TransAmount < 10000)
                {
                    $refund=$row->TransAmount-$play_min;
                    if(Disbursements::checkDuplicate($row->id,$row->MSISDN,$refund) ==0)
                    {
                        Disbursements::saveDisbursement($row->id,$row->FirstName.$row->LastName,$row->MSISDN,$refund,"refund",0,NULL);
                    }
                    $row->deleted_at=date("Y-m-d H:i:s");
                    $row->state=1;
                    $row->save(false);
                    Myhelper::setSms('invalidDrawAmount',$row->MSISDN,[$row->FirstName],NULL);
                } 
                else
                {
                    $refund=$row->TransAmount-$play_min;
                    if(Disbursements::checkDuplicate($row->id,$row->MSISDN,$refund) ==0)
                    {
                        Disbursements::saveDisbursement($row->id,$row->FirstName.$row->LastName,$row->MSISDN,$refund,"refund",4,NULL);
                    }
                    $row->deleted_at=date("Y-m-d H:i:s");
                    $row->state=1;
                    $row->save(false);

                }
               
            }

            
        }
    }
    public static function actionRemovedups()
    {
        Myhelper::checkRemoteAddress();
        $dups=TransactionHistories::getDuplicates();
        for($i=0;$i < count($dups); $i++)
        {
            $row=$dups[$i];
            TransactionHistories::removeDups($row['mpesa_payment_id'],$row['total']-1);
        }
    }
}
