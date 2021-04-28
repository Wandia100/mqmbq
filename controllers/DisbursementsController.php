<?php

namespace app\controllers;

use Yii;
use app\models\Disbursements;
use app\models\DisbursementsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Webpatser\Uuid\Uuid;
use app\components\Myhelper;
use yii\db\IntegrityException;
/**
 * DisbursementsController implements the CRUD actions for Disbursements model.
 */
class DisbursementsController extends Controller
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
                        'actions' => ['create', 'update','index','indexc','toggledisbursement'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(29) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(28) );
                                return in_array( Yii::$app->user->identity->email, $users );
                            }
                        }
                    ],
                    [
                        'actions' => ['indexc'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if ( ! Yii::$app->user->isGuest ) {
                                $users = Yii::$app->myhelper->getMembers( array( '' ), array(30) );
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
     * Lists all Disbursements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisbursementsSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);
         if(isset($_GET['id']) && isset($_GET['srr']) && $_GET['srr'] == 'failed'){
            $model = $this->findModel($_GET['id']);
            $model->status = 0;
            $model->save(FALSE);
            return $this->redirect('index');
        }
         $act = new \app\models\ActivityLog();
        $act -> desc = "disbursement report";
        $act ->setLog();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    /**
     * Method to toggle disbursement
     */
    public function actionToggledisbursement(){
        $field         = $_POST['field'];
        $mod           = Disbursements::findOne( $_POST['id'] );
        $mod->$field   = $_POST['value'];
        $mod->save( false );
    }

    /**
     * Lists all Disbursements models.
     * @return mixed
     */
    public function actionIndexc()
    {
        $searchModel = new DisbursementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if(isset($_GET['id']) && isset($_GET['srr']) && $_GET['srr'] == 'failed'){
            $model = $this->findModel($_GET['id']);
            $model->status = 0;
            $model->save(FALSE);
        }
        

        return $this->render('indexc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Disbursements model.
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
     * Creates a new Disbursements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Disbursements();

        if ($model->load(Yii::$app->request->post()) ) {

            try
            {
                    $model->id=Uuid::generate()->string;
                if(trim($model->phone_number)[0]=="0")
                {
                    $model->phone_number="254".substr(trim($model->phone_number),1);
                }
                else
                {
                    $model->phone_number=trim($model->phone_number);
                }
                $model->unique_field=$model->phone_number.$model->amount.date('YmdHi');
                $model->created_at = date('Y-m-d H:i:s');
                $model->save();
            }
            catch (IntegrityException $e) {
                //allowing execution
            }
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Disbursements model.
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
     * Deletes an existing Disbursements model.
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
     * Finds the Disbursements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Disbursements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Disbursements::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public static function actionRemovedups()
    {
        Myhelper::checkRemoteAddress();
        $dups=Disbursements::getDuplicates();
        for($i=0;$i < count($dups); $i++)
        {
            $row=$dups[$i];
            Disbursements::removeDups($row['unique_field'],$row['total']-1);
        }
    }

}
