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
use yii\web\UploadedFile;
use yii\db\IntegrityException;


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
       try {
            $searchModel  = new MpesaPaymentsSearch();
            $model        = new MpesaPayments();
            $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);
            if ($model->load(Yii::$app->request->post()) && isset($_POST['MpesaPayments']['excelfile'])) {
                $model->excelfile = UploadedFile::getInstance($model, 'excelfile');
             
                if ($model->upload()) {
                    #$model->logFileUpload();
                    Yii::$app->session->setFlash('success','file specimenuploaded');
                }
            }
        } catch (\Exception $exc) {
            Yii::$app->session->setFlash('error', $exc->getMessage());
            Yii::error($exc->getMessage());
            Yii::error($exc->getTraceAsString());
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
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
        Myhelper::checkRemoteAddress();
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
    public function actionInsertpayment($reference_code,$amount,$limit)
    {
        Myhelper::checkRemoteAddress();
        for($i=1000;$i< $limit; $i++)
        {
            try
            {
                $model = new MpesaPayments();
                $model->id=Uuid::generate()->string;
                $model->TransID = "bwjk".$i;
                $model->FirstName = "bwjk";
                $model->MiddleName ="bwjk";
                $model->LastName = "bwjk";
                $model->MSISDN = "254728202194";
                $model->InvoiceNumber = "bwjk";
                $model->BusinessShortCode = "bwjk";
                $model->ThirdPartyTransID ="bwjk";
                $model->TransactionType = "bwjk";
                $model->OrgAccountBalance = 0;
                $model->BillRefNumber = $reference_code;
                $model->TransAmount = $amount;
                $model->created_at=date("Y-m-d H:i:s");
                $model->updated_at=date("Y-m-d H:i:s");
                $model->save(false);
            }
            catch (IntegrityException $e) {
                //allow execution
            }
            
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
    public static function actionRemovedups()
    {
        Myhelper::checkRemoteAddress();
        $dups=MpesaPayments::getDuplicates();
        for($i=0;$i < count($dups); $i++)
        {
            $row=$dups[$i];
            MpesaPayments::removeDups($row['TransID'],$row['total']-1);
        }
    }
    public function beforeAction($action)
{            
    if (in_array($action->id,array('save','insertpayment'))) {
        $this->enableCsrfValidation = false;
    }

    return parent::beforeAction($action);
}
}
