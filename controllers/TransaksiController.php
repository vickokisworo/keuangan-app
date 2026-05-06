<?php

namespace app\controllers;

use app\models\Transaksi;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Transaksi models.
     *
     * @return string
     */
    public function actionIndex($tipe = null)
    {
        $query = Transaksi::find()->where(['user_id' => \Yii::$app->user->id]);
        if ($tipe !== null) {
            $query->andWhere(['tipe' => $tipe]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tipe' => $tipe,
        ]);
    }

    /**
     * Displays a single Transaksi model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($tipe = null)
    {
        $model = new Transaksi();
        if ($tipe !== null) {
            $model->tipe = $tipe;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = \Yii::$app->user->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
            if ($tipe !== null) {
                $model->tipe = $tipe;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaksi model. (Disabled as per user request)
     */
    public function actionUpdate($id)
    {
        throw new NotFoundHttpException('Fitur ubah/edit transaksi telah dinonaktifkan.');
    }

    /**
     * Deletes an existing Transaksi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $tipe = $model->tipe;
        $model->delete();

        return $this->redirect(['index', 'tipe' => $tipe]);
    }

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne(['id' => $id, 'user_id' => \Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak tersedia atau Anda tidak memiliki akses.');
    }
}
