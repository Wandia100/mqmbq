<?php

namespace app\controllers;

use app\models\Itemsale;
use app\models\Transactions;
use Yii;
use app\models\Basket;
use app\models\BasketSearch;
use Webpatser\Uuid\Uuid;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BasketController implements the CRUD actions for Basket model.
 */
class BasketController extends Controller
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
     * Lists all Basket models.
     * @return mixed
     */
    public function actionIndex()
    {
        // Fetch all items from the Basket model
        $items = Basket::find()->all();
        
        // Render the view and pass the items as a parameter
        return $this->render('index', [
            'items' => $items,
        ]);
    }

    /**
     * Displays a single Basket model.
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
     * Creates a new Basket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Basket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Basket model.
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
     * Deletes an existing Basket model.
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
     * Finds the Basket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Basket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Basket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionIntobasket($id)
    {
        $model = Itemsale::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Calculate total price
            $model->totalprice = $model->outprice * $model->howmany;

            $basket = new Basket();
            $basket->id = Uuid::generate()->string;
            $basket->user_id = Yii::$app->user->id;
            $basket->amount = $model->totalprice;
            $basket->category_item_id = $model->id;
            $basket->category_id = $model->category_id;
            $basket->name = $model->name;
            $basket->description = $model->name;
            $basket->mode_payment = $model->modeofpayment;
            $basket->quantity = $model->howmany;
            $basket->item_code = $model->item_code;
            $basket->generate_barcode = $model->generate_barcode;

            if ($basket->save(false)) {
                // Fetch updated basket items for the current user
                $basketItems = Basket::find()
                    ->where(['user_id' => Yii::$app->user->id])
                    ->all();

                return $this->render('complete', [
                    'model' => new Basket(), // Create a new instance for the form in case it's needed
                'basketItems' => $basketItems,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save basket.');
                return $this->redirect(['itemsale/sale']);
            }
        }

        // If validation fails or on initial load, render the form or initial view
        return $this->redirect(['itemsale/sale']);
    }
    public function actionComplete()
{
    $selectedIds = Yii::$app->request->post('selectedIds'); // Receive selected IDs
    
    if (!empty($selectedIds)) {
        foreach ($selectedIds as $id) {
            $basketItem = Basket::findOne($id);

            if ($basketItem) {
                // Calculate new quantity after the transaction
                $newQuantity = $basketItem->categoryItem->quantity - $basketItem->quantity;

                if ($newQuantity < 1) {
                    Yii::$app->session->setFlash('error', 'Insufficient quantity in stock.');
                    return $this->redirect(['itemsale/index']);
                }

                // Create a new transaction record
                $transaction = new Transactions();
                $transaction->id = Yii::$app->security->generateRandomString(36);
                $transaction->user_id = $basketItem->user_id;
                $transaction->category_id = $basketItem->category_id;
                $transaction->category_item_id = $basketItem->category_item_id;
                $transaction->name = $basketItem->name;
                $transaction->description = $basketItem->description;
                $transaction->item_code = $basketItem->item_code;
                $transaction->mode_payment = $basketItem->mode_payment;
                $transaction->amount = $basketItem->amount;
                $transaction->quantity = $basketItem->quantity;
                $transaction->generate_barcode = $basketItem->generate_barcode;

                if ($transaction->save(false)) {
                    // Update quantity in category_items for the selected item
                    Yii::$app->db->createCommand()
                        ->update('category_items', 
                            ['quantity' => new Expression('quantity - :howMany')], 
                            ['id' => $basketItem->category_item_id]
                        )
                        ->bindValue(':howMany', $basketItem->quantity)
                        ->execute();

                    // Delete the basket item
                    $basketItem->delete();
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save transaction.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Basket item not found.');
            }
        }
        Yii::$app->session->setFlash('success', 'Transactions saved successfully.');
    } else {
        Yii::$app->session->setFlash('error', 'No items selected.');
    }

    return $this->redirect(['itemsale/index']);
}

}
