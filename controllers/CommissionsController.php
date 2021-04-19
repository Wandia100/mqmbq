<?php

namespace app\controllers;

use Yii;
use app\models\Commissions;
use app\models\StationShows;
use app\models\WinningHistories;
use app\models\StationShowCommissions;
use app\models\TransactionHistories;
use app\models\CommissionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;

/**
 * CommissionsController implements the CRUD actions for Commissions model.
 */
class CommissionsController extends Controller
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
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(27) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(26) );
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
     * Lists all Commissions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommissionsSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPresenter()
    {
        $searchModel = new CommissionsSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Commissions model.
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
     * Creates a new Commissions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Commissions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Commissions model.
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
     * Deletes an existing Commissions model.
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
    public function actionProcess()
    {
        //today processing
        $current_day=strtolower(date("l"));
        $current_date=date("Y-m-d");
        $pending_show=StationShows::getShowForCommission($current_day);
        $processed_shows=Commissions::processedCommission($current_date);
        $this->setCommission($current_day,$current_date,$pending_show,$processed_shows);
        if(date("H")=="00" && date("i") < 15)
        {
            $current_day=strtolower(date("l",strtotime('-1 day',time())));
            $current_date=date("Y-m-d",strtotime('-1 day',time()));
            $pending_show=StationShows::getShowForCommission($current_day);
            $processed_shows=Commissions::processedCommission($current_date);
            $this->setCommission($current_day,$current_date,$pending_show,$processed_shows);
        }
    }
    //code to process commissions
    public function setCommission($current_day,$current_date,$pending_show,$processed_shows)
    {
        for($i=0;$i<count($pending_show); $i++)
        {
            $show=$pending_show[$i];
            if(!in_array($show['id'],$processed_shows))
            {
                
                $target=$show['target'];//target
                
                $total_show_transactions=TransactionHistories::getTransactionTotal($show['id'],$current_date." ".$show['start_time'],$current_date." ".$show['end_time']);
                if($total_show_transactions['total'] >= $target)
                {
                    
                    $commissions=StationShowCommissions::getShowCommission($show['id']);
                    $total_payout=WinningHistories::getDayPayout($show['id'],$current_date);
                    $net_revenue=$total_show_transactions['total']-$total_payout['total'];
                    for($j=0;$j<count($commissions); $j++)
                    {
                        $comm=$commissions[$j];
                        $model=new Commissions();
                        $model->id=Uuid::generate()->string;
                        $model->station_id=$show['station_id'];
                        $model->station_show_id=$show['id'];
                        $model->c_type=$comm->perm_group;
                        $model->amount=round(($net_revenue*($comm->commission/100)));
                        $model->created_at=$current_date." ".date("H:i:s");
                        $model->save(false);
                    }
                }
                
            }
        }
       
    }

    /**
     * Finds the Commissions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Commissions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Commissions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
