<?php

namespace app\controllers;

use Yii;
use app\models\MpesaPayments;
use app\models\MpesaPaymentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;
use app\components\Myhelper;


/**
 * MpesapaymentsController implements the CRUD actions for MpesaPayments model.
 */
class MpesapaymentsController extends Controller
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
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(22) );
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
     * Lists all MpesaPayments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MpesaPaymentsSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MpesaPayments model.
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
     * Creates a new MpesaPayments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MpesaPayments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    //function for savebatch transactions
    public function actionSave()
    {
        $jsondata = file_get_contents('php://input');
        $value = json_decode($jsondata,true);
        $model = new MpesaPayments();
        $model->id=Uuid::generate()->string;
        $model->TransID = $value['TransID'];
        $model->FirstName = $value['FirstName'];
        $model->MiddleName = $value['MiddleName'];
        $model->LastName = $value['LastName'];
        $model->MSISDN = $value['MSISDN'];
        $model->InvoiceNumber = $value['InvoiceNumber'];
        $model->BusinessShortCode = $value['BusinessShortCode'];
        $model->ThirdPartyTransID = $value['ThirdPartyTransID'];
        $model->TransactionType = $value['TransactionType'];
        $model->OrgAccountBalance = $value['OrgAccountBalance'];
        $model->BillRefNumber = $value['BillRefNumber'];
        $model->TransAmount = $value['TransAmount'];
        $model->created_at=date("Y-m-d H:i:s");
        $model->updated_at=date("Y-m-d H:i:s");
        $model->save(false);
        $response['status'] = 'success';
        $response['message'] = 'success';
        $response['data'] = [];
        \Yii::$app->response->data = json_encode($response);
    }
    public function actionInsertpayment()
    {
        Myhelper::checkRemoteAddress();
        $data=MpesaPayments::find()->limit(10)->all();
        foreach($data as $row)
        {
            $model=new MpesaPayments();
            $model=$row;
            $model->id=Uuid::generate()->string;
            $model->BillRefNumber="RAMOGI";
            $model->TransAmount=400;
            $model->created_at=date("Y-m-d H:i:s");
            $model->updated_at=date("Y-m-d H:i:s");
            $model->state=0;
            $model->save(false);
        }
    }

    /**
     * Updates an existing MpesaPayments model.
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
     * Deletes an existing MpesaPayments model.
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
     * Finds the MpesaPayments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MpesaPayments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MpesaPayments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function beforeAction($action)
{            
    if ($action->id == 'save') {
        $this->enableCsrfValidation = false;
    }

    return parent::beforeAction($action);
}
}
