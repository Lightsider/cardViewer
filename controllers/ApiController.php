<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

// for different bots

class ApiController extends Controller
{
    public $layout = "api";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['users'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
                'only' => ['users'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionUsers()
    {
        $users = User::find()->orderBy(['date_reg'=>SORT_DESC])->limit(10)->asArray()->all();

        return $this->render("users",[
            'users'=>$users
        ]);
    }
}
