<?php

namespace app\controllers;

use app\models\Investasi;
use app\models\NilaiInvestasi;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class InvestasiController extends Controller
{
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
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Investasi::find()->where(['user_id' => Yii::$app->user->id])->with('jenisInvestasi'),
            'sort' => ['defaultOrder' => ['tanggal_beli' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Investasi();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->save()) {
                // Buat nilai historis awal
                $nilai = new NilaiInvestasi();
                $nilai->investasi_id = $model->id;
                $nilai->tanggal = $model->tanggal_beli;
                $nilai->nilai_saat_ini = $model->nominal_awal;
                $nilai->metode_id = $model->metode_id;
                $nilai->tipe = 'topup';
                $nilai->save();

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdateNilai($id)
    {
        $investasi = $this->findModel($id); // Security check
        $model = new NilaiInvestasi();
        $model->investasi_id = $investasi->id;
        $model->tanggal = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            $model->nilai_saat_ini = 0; // Diabaikan karena fitur nilai pasar dihapus
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Modal investasi berhasil ditambah.');
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Investasi::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman tidak ditemukan atau Anda tidak memiliki akses.');
    }
}
