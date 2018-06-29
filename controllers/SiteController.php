<?php

namespace app\controllers;

use app\models\CommentForm;
use app\models\Comments;
use app\models\Notes;
use app\models\NotesForm;
use app\models\Products;
use app\models\RegisterForm;
use app\models\Reviews;
use app\models\User;
use app\models\Users;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public $layout = "site";


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * displays one card
     */

    public function actionProduct()
    {
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            return $this->goHome();
        }

        $model = Products::findIdentity($id);


        //Получение путей картинок

        $model->images = explode(",", $model->images);

        if (empty($model))
            return $this->render('itemNotFound',
                [
                    'item' => 'Видеокарта'
                ]);
        else {
            $comment = new CommentForm();
            $comments = Comments::find()->where("id_product=" . $model->id)->all();
            if (Yii::$app->request->isPost) {
                $comment->load(Yii::$app->request->post());
                if ($comment->sendComment($model)) {
                    Yii::$app->session->setFlash('result', "success");
                    Yii::$app->session->setFlash('message', "Комментарий успешно оставлен");
                } else {
                    Yii::$app->session->setFlash('result', "danger");
                    Yii::$app->session->setFlash('message', "При отправке комментария что-то пошло не так");
                }
                $this->refresh();
            }
            return $this->render('product', [
                'product' => $model,
                'comments' => $comments,
                'commentForm' => $comment
            ]);
        }
    }

    public function actionUser()
    {
        $id = (int)Yii::$app->request->get('id');
        if (empty($id)) {
            return $this->goHome();
        }
        $user = User::findIdentity($id);

        if (empty($user))
            return $this->render('itemNotFound',
                [
                    'item' => 'пользователь'
                ]);
        else {

            $note = Notes::find()->where("id_user=".$id.
            " and id_owner=".Yii::$app->user->id)->one();
            $noteForm = new NotesForm();


            if(!empty($note))
                $noteForm->text=$note->text;
            else
                $noteForm->text="Здесь может быть ваша заметка об этом пользователе. Ее увидете только вы.";

            if(Yii::$app->request->isPost)
            {
                $noteForm->load(Yii::$app->request->post());

                if ($noteForm->sendNotes($user)) {
                    Yii::$app->session->setFlash('result', "success");
                    Yii::$app->session->setFlash('message', "Заметка успешно оставлена");
                } else {
                    Yii::$app->session->setFlash('result', "danger");
                    Yii::$app->session->setFlash('message', "При отправке заметки что-то пошло не так");
                }
                $this->redirect(Url::to(['site/user', 'id' => $id]));
            }

            return $this->render('user', [
                'user' => $user,
                'noteForm'=>$noteForm
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect("you/account");
        }

        $model = new LoginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            var_dump($model->login());
            return $this->redirect("you/account");
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

        return $this->redirect("/login");
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionReviews()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            try {
                $review = new Reviews();
                $review->name = $model->name;
                $review->email = $model->email;
                $review->message = $model->message;

                if ($review->save()) {
                    Yii::$app->session->setFlash('message', "Спасибо за ваш отзыв! 
            При необходимости, мы ответим вам на указанную почту");
                    return $this->refresh();
                } else {
                    throw new Exception("bad reviews");
                }
            }
            catch (Exception $e)
            {
                Yii::$app->session->setFlash('message', "Что-то пошло не так:( Попробуйте еще раз");
                return $this->refresh();
            }
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /*
     * get registration
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(["you/account"]);
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            try {
                if ($user = $model->register()) {

                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect(["you/account"]);
                    }
                }
            } catch (Exception $e) {
            }
        }

        return $this->render('register', [
            'model' => $model
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
