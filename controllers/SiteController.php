<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please login.');
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($tipe = null)
    {
        $userId = Yii::$app->user->id;

        $totalPemasukan = \app\models\Transaksi::find()
            ->where(['tipe' => 'pemasukan', 'user_id' => $userId])
            ->sum('nominal') ?? 0;

        $totalPengeluaran = \app\models\Transaksi::find()
            ->where(['tipe' => 'pengeluaran', 'user_id' => $userId])
            ->sum('nominal') ?? 0;

        $saldoTotal = \app\models\Transaksi::getSaldo($userId);

        // Saldo Cash (Tunai/Cash)
        $metodeCash = \app\models\Metode::find()
            ->where(['or', ['ilike', 'nama', 'tunai'], ['ilike', 'nama', 'cash']])
            ->all();
        
        $saldoCash = 0;
        foreach ($metodeCash as $m) {
            $saldoCash += \app\models\Transaksi::getSaldoByMetode($userId, $m->id);
        }

        // Saldo Non-Cash breakdown
        $allMetode = \app\models\Metode::find()->all();
        $nonCashBreakdown = [];
        $saldoNonCash = 0;

        foreach ($allMetode as $m) {
            $isCash = false;
            foreach ($metodeCash as $mc) {
                if ($mc->id == $m->id) {
                    $isCash = true;
                    break;
                }
            }

            if (!$isCash) {
                $saldoM = \app\models\Transaksi::getSaldoByMetode($userId, $m->id);
                $nonCashBreakdown[] = [
                    'nama' => $m->nama,
                    'icon' => $m->icon,
                    'saldo' => $saldoM
                ];
                $saldoNonCash += $saldoM;
            }
        }

        // Ringkasan Investasi per Jenis (Berdasarkan Total Modal)
        $investasiSummary = \app\models\Investasi::find()
            ->joinWith('jenisInvestasi')
            ->where(['investasi.user_id' => $userId])
            ->select([
                'jenis_investasi.id',
                'jenis_investasi.nama',
                '(SUM(investasi.nominal_awal) + COALESCE((SELECT SUM(jumlah_topup) FROM nilai_investasi ni JOIN investasi i2 ON ni.investasi_id = i2.id WHERE i2.jenis_investasi_id = jenis_investasi.id AND i2.user_id = ' . $userId . '), 0)) as total_nilai'
            ])
            ->groupBy(['jenis_investasi.id', 'jenis_investasi.nama'])
            ->asArray()
            ->all();

        return $this->render('index', [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoTotal' => $saldoTotal,
            'saldoCash' => $saldoCash,
            'saldoNonCash' => $saldoNonCash,
            'nonCashBreakdown' => $nonCashBreakdown,
            'investasiSummary' => $investasiSummary,
            'tipe' => $tipe,
        ]);
    }
}
