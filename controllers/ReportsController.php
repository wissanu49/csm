<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use app\models\Withdraw;

/**
 * UnitsController implements the CRUD actions for Units model.
 */
class ReportsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'daily_report', 'monthly_report', 'printdaily', 'printmonthly'],
                'rules' => [
                    [
                        'actions' => ['index', 'daily_report', 'monthly_report', 'printdaily', 'printmonthly'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return TRUE;
                            // if (Yii::$app->user->identity->role === 'Admin') {
                            //     return TRUE;
                            // }
                            // return FALSE;
                        },
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
     * Lists all Units models.
     * @return mixed
     */
    public function actionIndex() {

        if (Yii::$app->request->post()) {

            if (isset($_POST['monthlyreport']) && $_POST['monthlyreport'] == true) {
                return $this->render('index', [
                            'mode' => 'monthly',
                ]);
            }
        }

        return $this->render('index', [
                    'mode' => NULL,
                    'dataProvider' => NULL,
        ]);
    }

    public function actionDaily() {

        if (Yii::$app->request->post()) {

            if (isset($_POST['dailyreport']) && $_POST['dailyreport'] == true) {

                $date = $_POST['date'];
                $dataProvider = Withdraw::find()->where(['date_withdraw' => $date, 'void' => 'false'])->all();

                return $this->render('daily', [
                            'date' => $date,
                            'dataProvider' => $dataProvider,
                ]);
            }
        }
    }

    public function actionPrintdaily($date) {

        $dataProvider = Withdraw::find()->where(['date_withdraw' => $date, 'void' => 'false'])->all();

        $content = $this->renderPartial('print_daily', [
            'date' => $date,
            'dataProvider' => $dataProvider,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, //
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            //'format' => [210, 148.5], // half A4
            'marginLeft' => 10,
            'marginRight' => 10,
            'marginTop' => 10,
            'marginBottom' => 10,
            'marginHeader' => 10,
            'marginFooter' => 10,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile' => '@web/css/pdf.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Report'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        return $pdf->render();
    }

    public function actionMonthly() {

        if (Yii::$app->request->post()) {

            if (isset($_POST['monthlyreport']) && $_POST['monthlyreport'] == true) {

                $date_from = $_POST['date_from'];
                $date_to = $_POST['date_to'];
                $dataProvider = Withdraw::find()->where("date_withdraw BETWEEN :df AND :dt AND void = 'false'", [':df' => $date_from, ':dt' => $date_to])->all();

                return $this->render('monthly', [
                            'date_from' => $date_from,
                            'date_to' => $date_to,
                            'dataProvider' => $dataProvider,
                ]);
            }
        }
    }

    public function actionPrintmonthly($date_from, $date_to) {

        $dataProvider = Withdraw::find()->where("date_withdraw BETWEEN :df AND :dt AND void = 'false'", [':df' => $date_from, ':dt' => $date_to])->orderBy('date_withdraw ASC')->all();

        $content = $this->renderPartial('print_monthly', [
            'date_from' => $date_from,
            'date_to' => $date_to,
            'dataProvider' => $dataProvider,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, //
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            //'format' => [210, 148.5], // half A4
            'marginLeft' => 10,
            'marginRight' => 10,
            'marginTop' => 10,
            'marginBottom' => 10,
            'marginHeader' => 10,
            'marginFooter' => 10,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile' => '@web/css/pdf.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Report'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        return $pdf->render();
    }

}
