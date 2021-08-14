<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;
use app\models\WinningHistories;
use app\models\WinningHistoriesSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','logout'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index','logout'],
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
                    #'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(in_array($_SERVER['SERVER_NAME'],COTZ))
        {
            $currency="Tsh ";
        }
        else{
            $currency="Ksh ";
        }
        if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group==3){
            return $this->redirect( [ '/transactionhistories/presenter' ] );
        }else if(isset(Yii::$app->user->identity->perm_group) && Yii::$app->user->identity->perm_group==6){
            return $this->redirect( [ '/winninghistories/index' ] );
        }else{
            $searchModel = new WinningHistoriesSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','','','',1);
            $today_income = \app\models\MpesaPayments::getMpesaCounts('today');
            $today_payout=WinningHistories::getPayout(date("Y-m-d"))['total'];
            $yesterday_payout= \app\models\SiteReport::getSiteReport('yesterday_payout');
            return $this->render('index', [
                'currency' => $currency,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'today_income' => $today_income,
                'today_payout' => $today_payout,
                'yesterday_payout' => $yesterday_payout,
            ]);
        }
    }

    /**
        * Login action.
        * @return Response|string
    */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }            


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
