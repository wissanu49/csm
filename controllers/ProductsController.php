<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\Units;
use app\models\SearchProducts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchProducts();
        $model = new Products();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        try {
            $model = new Products();
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
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {

        try {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อย');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                }
            }
           
                return $this->renderAjax('_update', [
                            'model' => $model,
                ]);
            
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        try {
            if (!$this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อย');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
                return $this->redirect(['index']);
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('error', $ex);
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
