<?php

namespace app\controllers;

use app\components\Myhelper;
use Yii;
use app\models\Bonus;
use app\models\BonusSearch;
use app\models\Disbursements;
use app\models\StationShowPresenters;
use app\models\StationShowPrizes;
use app\models\StationShows;
use app\models\TransactionHistories;
use app\models\WinningHistories;
use Webpatser\Uuid\Uuid;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BonusController implements the CRUD actions for Bonus model.
 */
class BonusController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','draw'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index','draw'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(42) );
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
     * Lists all Bonus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BonusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDraw($show_id="",$from="")
    {
        //$presenter=Yii::$app->user->identity;
        $presenter=[];
        $transaction_total=0;
        $transaction_count=0;
        $target_achievement=0;
        $show_name="No draw at this moment";
        $recent_winners=array();
        $show_prizes=array();
        $percent_raised=0;
        $percent_pending=0;    
        $presenter_station_show=[];
        $shows=StationShows::getStationShows();
        if(!empty($show_id) && !empty($from))
        {
            $presenter_station_show=StationShowPresenters::adminStationShow($show_id,strtolower(date("l",strtotime($from))));
            if(!empty($presenter_station_show))
                {
                    $station_show_id=$presenter_station_show['station_show_id'];
                    $station_id=$presenter_station_show['station_id'];
                    $station_name=$presenter_station_show['station_name'];
                    $start_time=$from." ".$presenter_station_show['start_time'];
                    $end_time=$from." ".$presenter_station_show['end_time'];
                    $show_transactions=TransactionHistories::getShowTransactions($station_show_id,$start_time,$end_time);
                    $transaction_total=TransactionHistories::getTransactionTotal($station_show_id,$start_time,$end_time)['total'];
                    $transaction_count=count($show_transactions);
                    $target_achievement=round(($transaction_total/$presenter_station_show['target'])*100,2);
                    $show_name=$presenter_station_show['show_name']." ".$presenter_station_show['start_time']." - ".$presenter_station_show['end_time'];
                    $recent_winners=Bonus::getRecentWinners($presenter_station_show['station_show_id'],$from);
                    $show_prizes=StationShowPrizes::getShowPrizes(strtolower(date("l",strtotime($from))),$presenter_station_show['station_show_id'],$from);
                    $percent_raised=round(($transaction_total/$presenter_station_show['target'])*100,2);
                    $percent_pending=round((($presenter_station_show['target']-$transaction_total)/$presenter_station_show['target'])*100,2);
                }
            if(isset($_POST['limit']) && isset($_POST['amount']) && !empty($_POST['limit']) && !empty($_POST['amount']) && $_POST['amount'] > 0 ){//Disburse amount
                
                //pick a random person
                $past_winners=Bonus::distinctWinners($station_id,30,date("Y-m-d H:i:s"));
                array_push($past_winners,'1');
                $bonus_winners=TransactionHistories::pickBonusWinners($show_id,$past_winners,$from,$_POST['limit']);
                $created_by=(isset(Yii::$app->user->identity->id))?Yii::$app->user->identity->id:0;
                foreach($bonus_winners as $winner)
                {
                    
                    $bonus_id=Uuid::generate()->string;
                    Bonus::saveBonus($bonus_id,$station_id,$show_id,$station_name,$show_name,$winner['reference_phone'],$_POST['amount'],$created_by);
                    Disbursements::saveDisbursement($bonus_id,NULL,$winner['reference_phone'],$_POST['amount'],"winning",0,$station_id);
                    $arr=[$_POST['amount'],$station_name];
                    Myhelper::setSms('bonus',$winner['reference_phone'],$arr,SENDER_NAME,$station_id);

                }
                return $this->redirect(['draw', 'show_id' => $show_id,'from'=>$from]);
            }
        }
        
        //echo json_encode($show_prizes); exit();
        
        $act = new \app\models\ActivityLog();
        $act -> desc = "Admin Draws";
        $act ->setLog();
        
        return $this->render('bonus_draw', [
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
     * Displays a single Bonus model.
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
     * Creates a new Bonus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bonus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bonus model.
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
     * Deletes an existing Bonus model.
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
     * Finds the Bonus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bonus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bonus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
