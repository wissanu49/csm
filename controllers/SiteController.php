<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'error'],
                'rules' => [
                    [
                        'actions' => ['index','error','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                         
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],                         
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
            /*
            'page' => [
		'class' => 'yii\web\ViewAction',
            ],
             * 
             */
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //die($month);
        //$start = \date("Y-m-d", \strtotime("first day of this month"));
        //$stop = \date("Y-m-d", \strtotime("last day of this month"));
        
        //die($start." ".$stop);
        
        $income = new \app\models\Withdraw();
        $monthly_income = $income->getMonthly_income();
        $today_income = $income->getToday_income();
        $lastmonth_income = $income->getLastmonth_income();
        $weekly_income = $income->getWeekly_income();
        
        $summary_report = $income->getSummary_income();
        
        return $this->render('index',[
            'monthly_income' => $monthly_income,
            'today_income' => $today_income,
            'lastmonth_income' => $lastmonth_income,
            'weekly_income' => $weekly_income,
            'summary_report' => $summary_report,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
            //return $this->redirect(['site/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            //return $this->redirect(['site/index']);
            return $this->goHome();
        }
        
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
