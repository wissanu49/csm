<?php

namespace app\controllers;

use Yii;
use app\models\Withdraw;
use app\models\SearchWithdraw;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;
use app\models\SubDeposits;
use app\models\Deposits;
use kartik\mpdf\Pdf;

/**
 * WithdrawController implements the CRUD actions for Withdraw model.
 */
class WithdrawController extends Controller {

    /**
     * @inheritdoc
     */
    public $KEY_RUN = 'REC';
    public $FIELD_NAME = 'withdraw_id';
    public $TABLE_NAME = 'withdraw';
    public $Month, $Year, $CODE, $LastID, $Key, $last_id = "";  // เก็บค่าเดือน เช่น 04  date("m")
    public $last_3_digit, $new_3_digit;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete', 'bill' , 'additem', 'addcarts', 'removeitem', 'savedata', 'printpdf', 'printpdfa4', 'printpdfdot', 'checkout'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'bill', 'additem', 'addcarts', 'removeitem', 'savedata', 'printpdf', 'printpdfa4','printpdfdot', 'checkout'],
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
     * Lists all Withdraw models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchWithdraw();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Withdraw model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        
        $withdraw = \app\models\Withdraw::find()->select('withdraw_id')->where(['id' => $id])->one();
        $dataProvider = \app\models\Withdraw::find()->where(['withdraw_id' => $withdraw->withdraw_id])->all();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    //'withdraw' => $withdraw,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Withdraw model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        try {
            $model = new Withdraw();
            $model->id = Withdraw::find()->count('[[id]]');
            if ($model->load(Yii::$app->request->post())) {

                $model->id = $model->id + 1;

                if ($model->save()) {
                    
                }
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        } catch (Exception $ex) {
            
        }
    }

    public function actionSavedata() {        
        $date = date('Y-m-d');
        $transection = Yii::$app->db->beginTransaction();
        $runningcodes = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
        //die($runningcodes);
        $flag = 0;
        try {
            foreach ($_SESSION['items'] as $key => $carts) {
                
                //$deposit = $carts['depid'];
                
                $model = new Withdraw();
                $model->id = Withdraw::find()->count('[[id]]');
                $model->date_withdraw = $date;
                $model->users_id = Yii::$app->user->identity->id;
                $model->id = $model->id + 1;
                $product = new Products();
                $productprice = $product->getPrice($carts['proid']);
                $deposit = Deposits::find()->select('deposit_date')->where(['id' => $carts['depid']])->one();

                $time = new Withdraw();
                $compare = $time->CheckDate($deposit->deposit_date);

                if ($compare < 1) {
                    $compare = 1;
                }
                $model->price = (($carts['amount'] * $productprice->price) * $compare);
                $model->withdraw_id = $runningcodes;
                $model->deposits_id = $carts['depid'];
                $model->products_id = $carts['proid'];
                $model->amount = $carts['amount'];
                
                $depId = $model->deposits_id;
                //$save = $model->save();

                if ($model->save()) {
                    //$subdep = new withdraw();
                    $subdep = SubDeposits::find()->select(['id', 'balance'])->where(['products_id' => $carts['proid'], 'deposits_id' => $carts['depid']])->one();
                    $subdep->id = Withdraw::find()->count('[[id]]');
                    $subdep->id = $subdep->id + 1;

                    $balance = $subdep->balance - $model->amount;
                    // update balance
                    //$up_balance = Yii::$app->db->createCommand()->update('sub_deposits', ['balance' => $balance], ['products_id' => $carts['proid'], 'deposits_id' => $carts['depid']])->execute();
                    Yii::$app->db->createCommand()->update('sub_deposits', ['balance' => $balance], ['products_id' => $carts['proid'], 'deposits_id' => $carts['depid']])->execute();

                    //if (!$up_balance) {
                    //    $flag = $flag + 1;
                    //}
                    
                } else {
                    $flag = $flag + 1;
                }
            }

            if ($flag == 0) {                
                
                // check total balance
                $chkBalance = SubDeposits::find()->select('SUM(balance) AS balance')->where(['deposits_id'=>$model->deposits_id])->one();
                
                //die(var_dump($chkBalance));
                // if balance = 0
                if($chkBalance->balance === 0){
                     // Update status to closed
                    Yii::$app->db->createCommand()->update('deposits', ['status' => 'closed'], [ 'id' => $model->deposits_id])->execute();
                }
                
                $transection->commit();
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                unset(Yii::$app->session['items']);
                
                $this->redirect(['bill', 'billid'=> $runningcodes, 'depid'=>$depId]);
            } else {
                $transection->rollBack();
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                $this->redirect(['deposits/view', 'id'=>$deposit]);
            }

            
            //$this->redirect(['deposits/index']);
        } catch (Exception $ex) {
            
        }
    }

    public function actionAdditem($id, $pid = null) {

        //$productinfo = new \app\models\Products();
        $product = Products::getProduct($pid);
        //$amount = SubDeposits::getAmount($id, $pid);
        $balance = SubDeposits::getBalance($id, $pid);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('additems', [
                        'proname' => $product->name,
                        'proid' => $pid,
                        'depid' => $id,
                        'balance' => $balance->balance,
            ]);
        } else {
            return $this->render('additems', [
                        'proname' => $product->name,
                        'proid' => $pid,
                        'depid' => $id,
                        'balance' => $balance->balance,
            ]);
        }
    }

    public function actionAddcarts() {
        $session = Yii::$app->session;
        $request = Yii::$app->request->post();
        $info = [
            'depid' => $request['deposits_id'],
            'proid' => $request['products_id'],
            'amount' => $request['amount'],
        ];
        $cart = new Withdraw();
        $cart->Carts($request['products_id'], $info);
        $items = $session['items'];
        return $this->redirect(['deposits/view',
                    'id' => $request['deposits_id'],
                        //'items' => $items,
        ]);
    }

    public function actionRemoveitem($id, $depid) {
        //$session = Yii::$app->session;   

        unset($_SESSION['items'][$id]);
        return $this->redirect(['deposits/view',
                    'id' => $depid,
        ]);
    }

    public function actionClearcarts($id) {
        $session = Yii::$app->session;

        $session['items'] = NULL;
        return $this->redirect(['deposits/view',
                    'id' => $id,
        ]);
    }

    public function actionCheckout($id) {

        $model = new Withdraw();
        $model->id = Withdraw::find()->count('[[id]]');

        $dataProvider = \app\models\SubDeposits::find()->where(['deposits_id' => $id])->all();
        if ($model->load(Yii::$app->request->post())) {

            $model->date_withdraw = date('Y-m-d');
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_checkout', [
                        'model' => $model,
                        'id' => $id,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('_checkout', [
                        'model' => $model,
                        'id' => $id,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Withdraw model.
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
    
    public function actionBill($billid, $depid){        
        
        $dataProvider = Withdraw::find()->where(['withdraw_id'=>$billid])->all();
        $depModel = Deposits::find()->where(['id'=>$depid])->all();
        return $this->render('bill',[
            'billid' => $billid,
            'depModel' => $depModel,
            'dataProvider' => $dataProvider,
            ]);
                
    }
    
    public function actionPrintpdf($id, $depid){
        
        $dataProvider = Withdraw::find()->where(['withdraw_id'=>$id])->all();
        $depModel = Deposits::find()->where(['id'=>$depid])->all();
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
                    'format' => [80,100],
                    'marginLeft' => 5,
                    'marginRight' => 5,
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
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => [
                        'title' => 'Billing',
                        ],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader' => false,
                        'SetFooter' => false,
                    ]
                ]);
                $pdf->getApi()->SetJS('this.print();');
                
                return $pdf->render();
    }
    
    public function actionPrintpdfa4($id, $depid){
        
        $dataProvider = Withdraw::find()->where(['withdraw_id'=>$id])->all();
        $depModel = Deposits::find()->where(['id'=>$depid])->all();
        $content = $this->renderPartial('printpdfA4',[
            'id' => $id,
            'depModel' => $depModel,
            'dataProvider' => $dataProvider,
            ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_UTF8, //
                    // A4 paper format
                    //'format' => Pdf::FORMAT_A4,
                    'format' => [210,148.5],
                    'marginLeft' => 5,
                    'marginRight' => 5,
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
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => [
                        'title' => 'Billing',
                        ],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader' => false,
                        'SetFooter' => false,
                    ]
                ]);
                $pdf->getApi()->SetJS('this.print();');
                
                return $pdf->render();
    }
    
    public function actionPrintpdfdot($id, $depid){
        
        $dataProvider = Withdraw::find()->where(['withdraw_id'=>$id])->all();
        $depModel = Deposits::find()->where(['id'=>$depid])->all();
        $content = $this->renderPartial('printpdfDot',[
            'id' => $id,
            'depModel' => $depModel,
            'dataProvider' => $dataProvider,
            ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_UTF8, //
                    // A4 paper format
                    //'format' => Pdf::FORMAT_A4,
                    'format' => [205,140],
                    'marginLeft' => 5,
                    'marginRight' => 5,
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
                    // any css to be embedded if required
                    'cssInline' => '.kv-heading-1{font-size:18px}',
                    // set mPDF properties on the fly
                    'options' => [
                        'title' => 'Billing',
                        ],
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
     * Deletes an existing Withdraw model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Withdraw model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Withdraw the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Withdraw::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function RunningCodes($field, $table, $key) {

        $this->Month = date("m");
        $this->Year = substr((date("Y")), 2);

        $this->CODE = $key . $this->Year . $this->Month;
        $run = $this->findCode($field, $table, $this->CODE);

        if (isset($run['id'])) {

            $this->last_id = $run['id'];
            //echo $last_id."<br>";
            $this->last_3_digit = substr($this->last_id, -3, 3); // ตัดเอาเฉพาะ 4 หลักสุดท้าย
            //echo $last_4_digit."<br>";

            $this->last_3_digit = $this->last_3_digit + 1;
            //echo $last_4_digit."<br>";
            while (strlen($this->last_3_digit) < 3) {
                $this->last_3_digit = "0" . $this->last_3_digit;
            }
            $this->CODE = $this->CODE . $this->last_3_digit;
            return $this->CODE;
            //$ObjQry=mysql_query("INSERT INTO create_id(row,id) VALUES('','$CODE')");
        } else {
            $this->CODE = $this->CODE . "001";
            return $this->CODE;
        }
    }

    public function findCode($field, $table, $code) {
        $sql = "SELECT MAX($field) as id FROM $table WHERE $field LIKE '$code%'";

        //$command = Yii::$app()->createCommand($sql);
        $row = Yii::$app->db->createCommand($sql)->queryOne();
        return $row;
    }

}
