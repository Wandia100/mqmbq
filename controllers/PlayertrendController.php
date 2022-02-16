<?php

namespace app\controllers;

use Yii;
use app\models\PlayerTrend;
use app\models\PlayerTrendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\MpesaPayments;
use yii\db\IntegrityException;
/**
 * PlayertrendController implements the CRUD actions for PlayerTrend model.
 */
class PlayertrendController extends Controller
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
     * Lists all PlayerTrend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlayerTrendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlayerTrend model.
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
     * Creates a new PlayerTrend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlayerTrend();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PlayerTrend model.
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
     * Deletes an existing PlayerTrend model.
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
    public function actionLogtrend()
    {
        $created_at=date("Y-m-d");
        $hour=date("H",strtotime("- 1 hour"));
        $data=MpesaPayments::getPlayerTrend($created_at." ".$hour);
        for($i=0; $i< count($data); $i++)
        {
            try
            {
                $model=new PlayerTrend();
                $model->msisdn=$data[$i]['msisdn'];
                $model->frequency=$data[$i]['frequency'];
                $model->hour=$hour;
                $model->station=$data[$i]['station'];
                $model->hour_date=$created_at;
                $model->station_id=$data[$i]['station_id'];
                $model->unique_field=$created_at.$hour.$model->station.$model->msisdn;
                $model->save(false);
            }
            catch(IntegrityException $e)
            {
                //do nothing
            }
        }
    }

    /**
     * Finds the PlayerTrend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlayerTrend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlayerTrend::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
