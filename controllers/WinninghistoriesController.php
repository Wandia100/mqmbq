<?php

namespace app\controllers;

use Yii;
use app\models\WinningHistories;
use app\models\StationShowPresenters;
use app\models\WinningHistoriesSearch;
use app\models\StationShowPrizes;
use app\models\TransactionHistories;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;

/**
 * WinninghistoriesController implements the CRUD actions for WinningHistories model.
 */
class WinninghistoriesController extends Controller
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
     * Lists all WinningHistories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WinningHistoriesSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WinningHistories model.
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
     * Creates a new WinningHistories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WinningHistories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionDraw()
    {
        $response['status']="";
        $response['message']="";
        $response['data']=[];
        $value=Yii::$app->request->post();
        $station_show_id=$value['station_show_id'];
        $presenter_id=$value['presenter_id'];
        $prize_id=$value['prize_id'];
        //if presenter is not admin drop him
        $presenter_show=StationShowPresenters::presenterStationShow($presenter_id,date("H"),strtolower(date("l")));
        if(!$presenter_show['is_admin'])
        {
            $response['status']="fail";
            $response['message']="PRESENTER MUST BE ADMIN";
        }
        $show_prize=StationShowPrizes::getShowPrize(strtolower(date("l")),$station_show_id,$prize_id);
        if($show_prize)
        {
            //pick a random person
            $transaction_history=TransactionHistories::pickRandom($station_show_id);
            if($transaction_history)
            {
                $model=new WinningHistories();
                $model->id=Uuid::generate()->string;
                $model->prize_id =$prize_id;
                $model->station_show_prize_id =$prize_id;
                $model->reference_name =$transaction_history['reference_name'];
                $model->reference_phone =$transaction_history['reference_phone'];
                $model->reference_code =$transaction_history['reference_code'];
                $model->station_id =$transaction_history['station_id'];
                $model->station_show_id =$transaction_history['station_show_id'];
                $model->presenter_id =$presenter_id;
                $model->amount =$transaction_history['amount'];
                $model->created_at =date("Y-m-d H:i:s");
                $model->status =0;
                //print_r($model);die();
                if($model->save(false))
                {
                    $draw_count_balance=$show_prize['draw_count']-$show_prize['prizes_given']-1;
                    $transaction_history['draw_count_balance']=$draw_count_balance;
                    //send an sms
                    //$sms_message = "Hi ".$transaction_history['reference_name']."!, You have won ".$show_prize['name']." worth Kshs $station_show_prize->amount from $station_name. You shall be called shortly with more details";
                    $response['status']="success";
                    $response['message']="no message";
                    $response['data']=$transaction_history;
                }
            }
            else{
                $response['status']="fail";
                $response['message']="FAILED TO DRAW! NO TRANSACTION!";
            }
            
        }
        else
        {
            $response['status']="fail";
            $response['message']="NO DRAWS LEFT FOR PRIZE(S)";
        }
        
        \Yii::$app->response->data = json_encode($response);

    }

    /**
     * Updates an existing WinningHistories model.
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
     * Deletes an existing WinningHistories model.
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
     * Finds the WinningHistories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WinningHistories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WinningHistories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function beforeAction($action)
    {            
        if ($action->id == '') {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }
}
