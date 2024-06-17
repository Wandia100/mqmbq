<?php

namespace app\controllers;
use Yii;
use app\models\Transactions;
use app\models\TransactionsSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * TransactionsController implements the CRUD actions for Transactions model.
 */
class TransactionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','presenter','admindraws','jackpotdraw','tv','tvdraw'],
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
     * Lists all Transactions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionsSearch();
        $dataProvider = Yii::$app->myhelper->getdataprovider($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transactions model.
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
     * Creates a new Transactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transactions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transactions model.
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
     * Deletes an existing Transactions model.
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
     * Finds the Transactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Transactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transactions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // app\controllers\TransactionsController.php

public function actionCancel($id)
{
    $model = $this->findModel($id);
//var_dump($model);exit;
    if ($model !== null) {
        // Check if $quantityToReturn is passed via POST request
        $quantityToReturn = Yii::$app->request->post('Transactions')['quantityToReturn'];
        //var_dump($quantityToReturn);exit;

        if ($quantityToReturn !== null) {
            if ($quantityToReturn > $model->quantity) {
                Yii::$app->session->setFlash('error', 'Quantity to return cannot be greater than the original quantity.');
                return $this->redirect(['site/index']);
            }
            // Begin a transaction
            $dbTransaction = Yii::$app->db->beginTransaction();
            try {
                // Update quantity in 'category_items' table
                Yii::$app->db->createCommand()
                    ->update('category_items', 
                        ['quantity' => new Expression('quantity + :quantityToReturn')], 
                        ['id' => $model->category_item_id]
                    )
                    ->bindValue(':quantityToReturn', $quantityToReturn)
                    ->execute();

                // Calculate amount to be subtracted based on 'inprice'
                $amountToSubtract = $quantityToReturn * $model->inprice;

                // Update amount in 'transactions' table
                Yii::$app->db->createCommand()
                    ->update('transactions',
                        ['amount' => new Expression('amount - :amountToSubtract')],
                        ['id' => $id]
                    )
                    ->bindValue(':amountToSubtract', $amountToSubtract)
                    ->execute();

                // Adjust the quantity in the transaction record
                $model->quantity -= $quantityToReturn;

                // Save the updated transaction (optional if you want to record the adjustment)
                $model->save(false); // Use false to skip validation

                // Commit the transaction
                $dbTransaction->commit();

                Yii::$app->session->setFlash('success', 'Transaction adjustment successful.');
                return $this->redirect(['itemsale/index']);
            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                $dbTransaction->rollBack();
                Yii::$app->session->setFlash('error', 'Failed to adjust transaction: ' . $e->getMessage());
            }
        }
    }
    return $this->render('return', ['model' => $model]);
}
    public function beforeAction($action)
    {            
        if (in_array($action->id,array('cancel'))) {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }
}
