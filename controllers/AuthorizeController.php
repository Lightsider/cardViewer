<?php

namespace app\controllers;

use app\models\AccountForm;
use app\models\Products;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class AuthorizeController extends Controller
{
    public $layout = "site";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        Yii::$app->view->params['nvidia'] = $this->getNvidia();
        Yii::$app->view->params['amd'] = $this->getAMD();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['account'],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['account'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionAccount()
    {
        $model = new AccountForm();
        $user = User::findIdentity(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            try {
                if ($user = $model->update()) {

                    Yii::$app->session->setFlash("result","success");
                    Yii::$app->session->setFlash("message","Изменения успешно сохранены");
                    return $this->redirect(["you/account"]);

                }
                else
                {
                    var_dump($user);die();
                    Yii::$app->session->setFlash("result","danger");
                    Yii::$app->session->setFlash("message","Что-то пошло не так");
                    return $this->redirect(["you/account"]);
                }
            } catch (Exception $e) {
            }
        }


        return $this->render('account', [
            'model' => $model,
            'user'=>$user
        ]);
    }

    public function getNvidia()
    {
        return Products::find()->where("id_category=1")->all();

    }

    public function getAMD()
    {
        return $amd = Products::find()->where("id_category=2")->all();
    }
}
