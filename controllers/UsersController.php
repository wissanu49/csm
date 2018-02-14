<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\SearchUsers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Helper\Scenario;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'create', 'changepwd'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'delete', 'create', 'changepwd'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->role === 'Admin') {
                                return true;
                            }
                            return false;
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        try {
            $model = new Users();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        try {
            $model = new Users(); //update
            $model = $this->findModel($id);
            $model->setScenario('update');

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }
            }

            return $this->render('update', [
                        'model' => $model,
            ]);
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangepwd($id) {

        $model = new Users();
        $model = Users::findIdentity($id);
        $model->setScenario('changepwd');

        $password = $model->password;
        if ($model->load(Yii::$app->request->post())) {

                if ($model->new_password != $model->repeat_password) {
                    Yii::$app->session->setFlash('error', 'รหัสผ่านใหม่ไม่ตรงกัน');
                    return $this->render('changepwd', [
                                'model' => $model,
                    ]);
                } else {
                    $model->password = Yii::$app->security->generatePasswordHash($model->new_password);
                    if ($model->save()) {

                        Yii::$app->session->setFlash('success', 'เปลี่ยนรหัสผ่านเรียบร้อย');
                        return $this->render('update', [
                                    'model' => $model,
                        ]);
                    } else {
                        Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด เปลี่ยนรหัสผ่านไม่สำเร็จ');
                        return $this->render('changepwd', [
                                    'model' => $model,
                        ]);
                    }
                
            }
        }
        return $this->render('changepwd', [
                    'model' => $model,
        ]);
    }

}
