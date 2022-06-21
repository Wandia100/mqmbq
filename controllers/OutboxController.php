<?php

namespace app\controllers;

use app\components\Myhelper;
use Yii;
use app\models\Outbox;
use app\models\OutboxSearch;
use app\models\SentSms;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OutboxController implements the CRUD actions for Outbox model.
 */
class OutboxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','bulk'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index','bulk'],
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
     * Lists all Outbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OutboxSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Outbox model.
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
    public function actionTzsms($limit)
    {

        $smses=Outbox::tzOutbox($limit);
        for($i=0; $i<count($smses); $i++)
        {
            $outbox=$smses[$i];
            if($outbox==NULL)
        {
            return;
        }
        $sentsms=new SentSms();
        $sentsms->receiver=$outbox->receiver;
        $sentsms->sender=$outbox->sender;
        $sentsms->message=$outbox->message;
        $sentsms->station_id=$outbox->station_id;
        $sentsms->created_date=$outbox->created_date;
        $sentsms->category=$outbox->category;
        $sentsms->save(false);
        $outbox->delete(false);
        $channel=Myhelper::getSmsChannel($sentsms->receiver);
            Myhelper::sendTzSms($sentsms->receiver,$sentsms->message,SENDER_NAME,$channel);
        }
    }

    /**
     * Creates a new Outbox model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Outbox();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Outbox model.
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
     * Deletes an existing Outbox model.
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
     * Finds the Outbox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Outbox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Outbox::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionBulk()
    {
        $model = new Outbox();
        if ($model->load(Yii::$app->request->post()) 
        && isset($model->message) 
        && !empty($model->message)) {
            Outbox::insertBulk($model->message);
            return $this->redirect(['outbox/index']);
        }

        return $this->render('bulk', [
            'model' => $model,
        ]);
    }
    public function actionBulky($limit)
    {
        $batch_size=ceil($limit/20);
        for($i=0; $i <20; $i++)
        {
            Outbox::jambobetBatch($batch_size);
        }
    }
    public  function actionRemovedups()
    {
        $dups=Outbox::getDuplicates();
        for($i=0;$i < count($dups); $i++)
        {
            $row=$dups[$i];
            Outbox::removeDups($row['receiver'],$row['total']-1);
        }
    }
    public function actionHello()
    {
        $sms=['receiver'=>"254728202194",'message'=>"hello world",'id'=>123456];
        $sms=json_decode(json_encode($sms));
       // echo $sms->receiver; exit();
        $result=Outbox::niTextSms($sms);
        var_dump($result);
    }
}
