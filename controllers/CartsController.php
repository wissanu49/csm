<?php

namespace app\controllers;

use Yii;
use app\models\Carts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Deposits;
use app\models\SubDeposits;

/**
 * CartsController implements the CRUD actions for Carts model.
 */
class CartsController extends Controller {

    public $KEY_RUN = 'DEP';
    public $FIELD_NAME = 'id';
    public $TABLE_NAME = 'deposits';
    public $Month, $Year, $CODE, $LastID, $Key, $last_id = "";  // เก็บค่าเดือน เช่น 04  date("m")
    public $last_3_digit, $new_3_digit;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'removeitem', 'checkout'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'removeitem', 'checkout'],
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
     * Lists all Carts models.
     * @return mixed
     */
    public function actionIndex() {

        $model = new Carts();
        $model->id = Carts::find()->count('[[id]]');

        if (Yii::$app->request->post()) {
            $transection = Yii::$app->db->beginTransaction();
            try {

                $model->load(Yii::$app->request->post());

                $model->session = Yii::$app->session->getId();
                $model->users_id = Yii::$app->user->identity->id;
                $model->id = $model->id + 1;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    $transection->commit();
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }

                $model = new Carts();
                $dataProvider = Carts::find()->where(['users_id' => Yii::$app->user->identity->id])->all();

                return $this->render('index', [
                            'model' => $model,
                            'dataProvider' => $dataProvider
                ]);
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', $ex);
            }
        } else {
            //$dataProvider = new ActiveDataProvider([
            //    'query' => Carts::find()->where(['users_id' => \Yii::$app->user->identity->id])->all(),
            //]);
            $dataProvider = Carts::find()->where(['users_id' => Yii::$app->user->identity->id])->all();
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        }
    }

    public function actionRemoveitem() {


        if (Yii::$app->request->get()) {
            try {
                $transection = Yii::$app->db->beginTransaction();
                $id = $_GET['id'];

                if ($this->findModel($id)->delete()) {
                    Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
                    $transection->commit();
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                    $transection->rollBack();
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', $ex);
            }
        }



        return $this->redirect(['index']);
    }

    public function actionCheckout() {

        $cartsModel = Carts::find()->where(['users_id' => Yii::$app->user->identity->id])->all();
        $runningcodes = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);

        $depositsModel = new Deposits();
        $depositsModel->id = $runningcodes;

        if (Yii::$app->request->post()) {
            $transection = Yii::$app->db->beginTransaction();
            try {
                $flag = 0;
                // Load Basket
                $cartsModel = Carts::find()->where(['users_id' => Yii::$app->user->identity->id])->all();
                //$runningcodes = self::RunningCodes($this->FIELD_NAME, $this->TABLE_NAME, $this->KEY_RUN);
                // Create Order                
                $depositsModel = new Deposits();
                //$depositsModel->id = Deposits::find()->count('[[id]]');
                $depositsModel->id = $_POST['Deposits']['id'];
                $depositsModel->customers_id = $_POST['Deposits']['customers_id'];
                $depositsModel->deposit_date = date('Y-m-d');
                $depositsModel->users_id = Yii::$app->user->identity->id;
                $depositsModel->comment = $_POST['Deposits']['comment'];

                //die(print_r($depositsModel));
                $depositsModel->save();
                if (!$depositsModel->save()) {
                    Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                    $flag = $flag + 1;
                }

                // COPY Carts To SubDeposits
                foreach ($cartsModel as $cart) {

                    $sub = new SubDeposits();
                    $sub->id = SubDeposits::find()->count('[[id]]');
                    $sub->id = $sub->id + 1;
                    $sub->products_id = $cart->products_id;
                    $sub->amount = $cart->amount;
                    $sub->balance = $cart->amount;
                    $sub->deposits_id = $runningcodes;
                    //die(var_dump($sub));
                    $sub->save();
                    if (!$sub->save()) {
                        $flag = $flag + 1;
                        Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                    }
                    //die(var_dump($sub));
                }

                Carts::deleteAll('users_id = :uid OR session = :session', [':uid' => Yii::$app->user->identity->id, ':session' => Yii::$app->session->getId()]);

                if ($flag == 0) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    $transection->commit();

                    return $this->redirect(['deposits/viewpdf',
                            'id' => $runningcodes,
                        ]);
                    
                } else {
                    $transection->rollBack();
                    return $this->redirect(['carts/index']);
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                //$transection->rollBack();
                return $this->redirect(['carts/index']);
            }
        }

        return $this->render('_checkout', [
                    'model' => $depositsModel,
                    'carts' => $cartsModel
        ]);
    }
    
    

    /**
     * Displays a single Carts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Carts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carts model.
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
     * Deletes an existing Carts model.
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
     * Finds the Carts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Carts::findOne($id)) !== null) {
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
