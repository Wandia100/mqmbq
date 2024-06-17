<?php

namespace app\controllers;

use app\models\CategoryItems;
use app\models\Itemsale;
use Yii;
use app\models\ReturnedBack;
use app\models\ReturnedBackSearch;
use Webpatser\Uuid\Uuid;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ReturnedbackController implements the CRUD actions for ReturnedBack model.
 */
class ReturnedbackController extends Controller
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
     * Lists all ReturnedBack models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReturnedBackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReturnedBack model.
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
     * Creates a new ReturnedBack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReturnedBack();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReturnedBack model.
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
     * Deletes an existing ReturnedBack model.
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
     * Finds the ReturnedBack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ReturnedBack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReturnedBack::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionReturned($id)
    {
        $model = CategoryItems::findOne($id);
        
        if (!$model) {
            throw new NotFoundHttpException('The requested item does not exist.');
        }
    
        $returned = new ReturnedBack();
        $returned->id = Uuid::generate()->string;
        $returned->category_item_id = $model->id;
        $returned->name = $model->name;
        $returned->outprice = $model->outprice;
        $returned->howmany = '';
        $returned->save(false);
    
        // Check if form is submitted and save the posted data into ReturnedBack model
        if ($returned->load(Yii::$app->request->post()) && $returned->save()) {
            Yii::$app->session->setFlash('success', 'Returned item saved successfully.');
            return $this->redirect(['view', 'id' => $returned->id]);
        }
    
        // Render the form view again with the model
        return $this->render('@app/views/category-items/return', ['model' => $model, 'returned' => $returned]);
    }
    public function actionAdminretun()
    {
        // Step 1: Count items returned per category_item_id
        $returnedCounts = ReturnedBack::find()
            ->select(['category_item_id', 'SUM(howmany) AS total_returned'])
            ->groupBy('category_item_id')
            ->asArray()
            ->all();

        // Step 2: Update category_items table based on the counts
        foreach ($returnedCounts as $returnedCount) {
            $categoryId = $returnedCount['category_item_id'];
            $totalReturned = $returnedCount['total_returned'];

            $categoryItem = CategoryItems::findOne($categoryId);
            if ($categoryItem) {
                $categoryItem->quantity += $totalReturned;
                $categoryItem->save();
            }
        }

        ReturnedBack::deleteAll();

        // Redirect to the homepage (adjust URL as per your application's structure)
        return $this->redirect(Url::home());
    }
    
}
