<?php

namespace app\controllers;

use Yii;
use app\models\Void;
use app\models\VoidSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * VoidController implements the CRUD actions for Void model.
 */
class VoidController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'User') {
                                return true;
                            }
                        },
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'delete',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'Admin') {
                                return true;
                            }
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
     * Lists all Void models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VoidSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Void model.
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
     * Creates a new Void model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Void();

        if (Yii::$app->request->post()) {
            try {

                $transection = Yii::$app->db->beginTransaction();



                $model = new Void();
                $model->id = Void::find()->count('[[id]]');
                $model->id = $model->id + 1;
                $model->type = $_POST['Void']['type'];
                $model->void_id = $_POST['Void']['void_id'];
                $model->status = 'request';
                $model->date_request = \date("Y-m-d H:i:s");
                $model->comment = $_POST['Void']['comment'];
                $model->users_id = Yii::$app->user->identity->id;

                if ($model->type == "rec") {
                    $check = \app\models\Withdraw::checkDocument($model->void_id);
                    if ($check == true) {
                        if ($model->save()) {

                            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                            $transection->commit();
                            return $this->redirect(['index']);
                        } else {
                            return $this->redirect(['index']);
                            Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'ไม่พบหมายเลขเอกสาร กรุณาตรวจสอบอีกครั้ง');
                        return $this->render('create', [
                                    'model' => $model,
                        ]);
                    }
                } else if ($model->type == "dep") {
                    $check = \app\models\Deposits::checkDocument($model->void_id);
                    if ($check == true) {
                        if ($model->save()) {

                            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                            $transection->commit();
                            return $this->redirect(['index']);
                        } else {
                            return $this->redirect(['index']);
                            Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'ไม่พบหมายเลขเอกสาร กรุณาตรวจสอบอีกครั้ง');
                        return $this->render('create', [
                                    'model' => $model,
                        ]);
                    }
                }

                //$model->save();
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Void model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $flag = 0;
        if (Yii::$app->request->post()) {

            try {
                $transection = Yii::$app->db->beginTransaction();

                $model = $this->findModel($id);
                $model->id = $_POST['Void']['id'];
                $model->status = $_POST['Void']['status'];
                $model->date_action = \date("Y-m-d H:i:s");
                $model->comment = $_POST['Void']['comment'];

                if ($model->save()) {

                    if ($model->type == "rec") {
                        if ($model->status == 'approve') {
                            $withQuery = new \app\models\Withdraw();
                            $withData = $withQuery->getRecjob($model->void_id);
                            //die(var_dump($withData));
                            foreach ($withData as $data) {
                                $depid = $data['deposits_id'];
                                $amount = $data['amount'];
                                $witCommand = Yii::$app->db->createCommand("UPDATE withdraw SET void = 'true' WHERE withdraw_id = '" . $model->void_id . "'");
                                $updatewit = $witCommand->execute();


                                $qry = "SELECT balance FROM sub_deposits WHERE deposits_id = '" . $data['deposits_id'] . "' AND products_id = '" . $data['products_id'] . "'";
                                $res = Yii::$app->db->createCommand($qry)->queryOne();
                                $balance = $res['balance'];
                                $sum = ($amount + $balance);
                                $AmountCommand = Yii::$app->db->createCommand("UPDATE sub_deposits SET balance = '" . $sum . "' WHERE deposits_id = '" . $data['deposits_id'] . "' AND products_id = '" . $data['products_id'] . "'");
                                $updateAmount = $AmountCommand->execute();
                            }

                            $DepCommand = Yii::$app->db->createCommand("UPDATE deposits SET status = 'remain' WHERE id = '" . $depid . "'");
                            $updatedep = $DepCommand->execute();
                        }
                        if ($flag == 0) {
                            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                            $transection->commit();
                            return $this->redirect(['index']);
                        } else {
                            Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                            $transection->rollBack();
                            return $this->redirect(['index']);
                        }
                    } else if ($model->type == "dep") {
                        if ($model->status == 'approve') {
                            $depModel = \app\models\Deposits::find()->where(['id' => $model->void_id])->all();

                            foreach ($depModel as $data) {
                                $dep_id = $data->id;
                            }

                            $updatedep = Yii::$app->db->createCommand()->update('deposits', ['status' => 'void'], ['id' => $dep_id])->execute();

                            if (!$updatedep) {
                                $flag = $flag + 1;
                            }
                        }
                    }

                    if ($flag == 0) {
                        Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                        $transection->commit();
                        return $this->redirect(['index']);
                    } else {
                        Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                        $transection->rollBack();
                        return $this->redirect(['index']);
                    }
                } else {
                    return $this->redirect(['index']);
                    Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกรายการได้');
                }
            } catch (Exception $ex) {
                return $this->redirect(['index']);
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
            }

            return $this->redirect(['index', 'model' => $model]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Void model.
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
     * Finds the Void model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Void the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Void::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
