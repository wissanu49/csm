<?php

namespace app\controllers;

use Yii;
use app\models\Customers;
use app\models\SearchCustomers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete', 'report'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'report'],
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
     * Lists all Customers models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchCustomers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customers model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionReport($uid = NULL) {

        $searchModel = new SearchCustomers();

        $date = date('Y-m-d');
        if (Yii::$app->request->post()) {
            $uid = $_POST['SearchCustomers']['id'];
            /*
              if ($_POST['SearchCustomers']['date'] != NULL || $_POST['SearchCustomers']['date'] != "") {
              $date = $_POST['SearchCustomers']['date'];
              }
             * 
             */
        }


        $queryDep = new \yii\db\Query();
        $queryWith = new \yii\db\Query();
        $queryRemain = new \yii\db\Query();

        $queryRemain->select(['sub_deposits.*', 'products.name'])
        ->from('sub_deposits')
        ->join('LEFT JOIN', 'deposits', 'sub_deposits.deposits_id = deposits.id')
        ->join('LEFT JOIN', 'products', 'sub_deposits.products_id = products.id')
        ->where(['deposits.status' => 'remain','deposits.customers_id' => $uid,])
        ->andWhere(['NOT IN', 'sub_deposits.balance', ['0']]);

        $queryWith->select(['withdraw.*', 'products.name', 'deposits.id', 'deposits.customers_id'])
                ->from('withdraw')
                ->join('LEFT JOIN', 'deposits', 'deposits.id = withdraw.deposits_id')
                ->join('LEFT JOIN', 'products', 'withdraw.products_id = products.id')
                ->where(['withdraw.date_withdraw' => $date, 'deposits.customers_id' => $uid, 'void' => 'false']);

        $queryDep->select(['sub_deposits.*', 'deposits.id', 'deposits.deposit_date', 'products.name'])
                ->from('deposits')
                ->join('LEFT JOIN', 'sub_deposits', "deposits.id = sub_deposits.deposits_id")
                ->join('LEFT JOIN', 'products', 'sub_deposits.products_id = products.id')
                ->where(['deposits.deposit_date' => $date, 'deposits.customers_id' => $uid])
                ->andWhere(['NOT IN', 'deposits.status', ['void']]);

        $command = $queryDep->createCommand();
        $deposits = $command->queryAll();

        $command2 = $queryWith->createCommand();
        $withdraw = $command2->queryAll();

        $command3 = $queryRemain->createCommand();
        $remain = $command3->queryAll();

        return $this->render('report', [
                    'deposits' => $deposits,
                    'withdraw' => $withdraw,
                    'searchModel' => $searchModel,
                    'cusid' => $uid,
                    'remain' => $remain,
        ]);
    }

    /**
     * Creates a new Customers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Customers();
        try {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }
            }

            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Updates an existing Customers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        try {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }
            }

            return $this->renderAjax('update', [
                        'model' => $model,
            ]);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Deletes an existing Customers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        try {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }
            return $this->redirect(['index']);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
