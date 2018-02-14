<?php

namespace app\controllers;

use Yii;
use app\models\Deposits;
use app\models\SearchDeposits;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\SubDeposits;
use kartik\mpdf\Pdf;

/**
 * DepositsController implements the CRUD actions for Deposits model.
 */
class DepositsController extends Controller {

    /**
     * @inheritdoc
     */
    public $KEY_RUN = 'DEP';
    public $FIELD_NAME = 'id';
    public $TABLE_NAME = 'deposits';
    
    public  $Month,$Year,$CODE,$LastID,$Key,$last_id = "";		// เก็บค่าเดือน เช่น 04  date("m")
    public $last_3_digit,$new_3_digit;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete', 'view', 'viewpdf', 'printpdf'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'viewpdf', 'printpdf'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
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
     * Lists all Deposits models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchDeposits();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deposits model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        
        $dataProvider = \app\models\SubDeposits::find()->where(['deposits_id' => $id])->all();
        $withdraw = \app\models\Withdraw::find()->where(['deposits_id' => $id, 'void' => 'false'])->all();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'withdraw' => $withdraw,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Deposits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Deposits();
        //$runningcode = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
                    //'runningcode' => $runningcode,
        ]);
    }
    
    public function actionVoid($depid){
        
    }
    
    public function actionViewpdf($id){        
        
        $depModel = Deposits::find()->where(['id'=>$id])->all();
        $dataProvider = SubDeposits::find()->where(['deposits_id'=>$id])->all();
        return $this->render('viewpdf',[
            'id' => $id,
            'depModel' => $depModel,
            'dataProvider' => $dataProvider,
            ]);
                
    }
    
    public function actionPrintpdf($id){
        
        $dataProvider = SubDeposits::find()->where(['deposits_id'=>$id])->all();
        $depModel = Deposits::find()->where(['id'=>$id])->all();
        $content = $this->renderPartial('printpdf',[
            'id' => $id,
            'depModel' => $depModel,
            'dataProvider' => $dataProvider,
            ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_UTF8, //
                    // A4 paper format
                    //'format' => Pdf::FORMAT_A4,
                    //'format' => [210,148.5],
                    'format' => [80,100],
                    'marginLeft' => 2,
                    'marginRight' => 2,
                    'marginTop' => 5,
                    'marginBottom' => 5,
                    'marginHeader' => 5,
                    'marginFooter' => 5,
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
                    'options' => ['title' => 'Billing'],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader' => false,
                        'SetFooter' => false,
                    ]
                ]);
                
                $pdf->getApi()->SetJS('this.print();');

                return $pdf->render();
    }

    /**
     * Updates an existing Deposits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Deposits model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        try{
            if($this->findModel($id)->delete()){
                return $this->redirect(['index']);
            }
        } catch (Exception $ex) {

        }
        
    }

    /**
     * Finds the Deposits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deposits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Deposits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    

}
