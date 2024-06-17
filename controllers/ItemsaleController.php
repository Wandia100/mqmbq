<?php

namespace app\controllers;

use app\models\Basket;
use Yii;
use app\models\Itemsale;
use app\models\ItemsaleSearch;
use app\models\Transactions;
use Webpatser\Uuid\Uuid;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemsaleController implements the CRUD actions for Itemsale model.
 */
class ItemsaleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Itemsale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemsaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Itemsale model.
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
     * Creates a new Itemsale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Itemsale();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->id=Uuid::generate()->string;
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Itemsale model.
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
     * Deletes an existing Itemsale model.
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
     * Finds the Itemsale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Itemsale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Itemsale::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionSale($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post()) ) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('sale', ['model' => $model]);
    }
    public function actionSavePartial($id)
    {
        $model = Itemsale::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // No need to call $model->save() since we are not saving to the database
            Yii::$app->session->setFlash('success', 'Partial data saved successfully.');
            return $this->render('sale', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to save partial data.');
        }

        return $this->render('sale', ['model' => $model]);
    }

    public function actionCompleteSale($id)
    {
        $model = Itemsale::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Calculate total price
            $model->totalprice = $model->outprice * $model->howmany;

            $basketItemIds = Basket::find()
            ->select('id')
            ->where(['user_id' => Yii::$app->user->id])
            ->column();

            $transaction = new Transactions();
            $transaction->id = Uuid::generate()->string;
            $transaction->user_id = Yii::$app->user->id;
            $transaction->amount = $model->totalprice;
            $transaction->category_item_id = $model->id;
            $transaction->category_id = $model->category_id;
            $transaction->name = $model->name;
            $transaction->description = $model->name;
            $transaction->mode_payment = $model->modeofpayment;
            $transaction->quantity = $model->howmany;
            $transaction->item_code = $model->item_code;
            $transaction->generate_barcode = $model->generate_barcode;

            if ($transaction->save(false)) {
                // Update the quantity in the category_items table
                Yii::$app->db->createCommand()
                    ->update('category_items', 
                        ['quantity' => new \yii\db\Expression('quantity - :howMany')], 
                        ['id' => $transaction->category_item_id]
                    )
                    ->bindValue(':howMany', $model->howmany)
                    ->execute();

                    Yii::$app->db->createCommand()->delete('basket')->execute();

                Yii::$app->session->setFlash('success', 'Transaction saved successfully.');
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save transaction.');
            }
        }

        return $this->render('sale', ['model' => $model]);
    }
    public function actionReturned($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post()) ) {
            $model->howmany =$model->password;
            $model->save(false);
            Yii::$app->session->setFlash('success','Password was reset successfully!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('set_password', ['model' => $model]);
    }
        
    public function beforeAction($action)
    {            
        if (in_array($action->id,array('savesale'))) {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }

    
}    
