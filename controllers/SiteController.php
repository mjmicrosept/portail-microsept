<?php

namespace app\controllers;

use app\models\Client;
use app\models\LaboClientAssign;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\custom\LastLaboDocument;
use yii\data\ArrayDataProvider;
use app\models\User;
use app\models\PortailUsers;
use app\models\Labo;
use app\models\DocumentPushed;
use app\models\DocumentAlerte;
use app\models\AnalyseData;
use app\models\AnalyseDataGerme;
use app\models\AnalyseService;
use app\models\AnalyseInterpretation;
use app\models\AnalyseLieuPrelevement;
use app\models\AnalyseConditionnement;
use kartik\grid\GridView;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
            /*'error' => [
                'class' => 'yii\web\ErrorAction',
            ],*/
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'components'=>[
                'errorHandler'=>[
                    'errorAction'=>'site/error',
                ],
                'response' => [
                    'class' => 'yii\web\Response',
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // on renvoit l'utilisateur courant
        $user = User::getCurrentUser();
        if (is_null($user))
        {
            return $this->redirect('index.php/user-management/auth/login');
        }

        $listMonthAlert = [];
        for($i = 1; $i <= 12 ; $i++){
            $listMonthAlert[$i] = $i;
        }

        $searchModelLabo = null;
        $dataProviderLabo = null;
        $dataProviderAnalyse = null;
        $aGlobalDataAnalyse = [];
        $dataAnalyse = [];
        $gridColumn = [];
        $gridColumnAnalyse = [];
        $entete = [];



        return $this->render('index',[

        ]);
    }

    public function actionDashboard(){
        return $this->render('../dashboard/index',[

        ]);
    }

    public function actionError(){
        //return $this->render('index', ['user' => $user]);
        return $this->render('../system/error'.Yii::$app->response->getStatusCode());
    }

}
