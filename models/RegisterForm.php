<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Register is the model behind the login form.
 * @var RegisterForm $this
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $login;
    public $password;
    public $password_repeat;
    public $image = '';
    public $selfdescription;

    public $file = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот логин уже занят'],
            ['login', 'string', 'min' => 3, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 3],

            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 3],
            ['password_repeat', 'compare','compareAttribute'=>'password','message'=>'Пароли должны совпадать'],

            ['selfdescription', 'required'],
            ['selfdescription', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat'=>'Повторите пароль',
            'file'=>'Картинка',
            'selfdescription'=>'О себе'
        ];
    }

    /**
     * Registers user
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function register()
    {
        if (!$this->validate()) {
            var_dump($this->getErrors());die();
            return null;
        }

        $user = new User();

        $user->login = $this->login;
        $user->setPassword($this->password);

        if ($this->file) {
            $user->image = \Yii::$app->security->generateRandomString() . '.jpg';
        } else $user->image = "/uploads/no_image.png";
        $user->selfdescription=$this->selfdescription;

        $rbac = \Yii::$app->authManager;
        $userRole = $rbac->getRole('user');


        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($user->save()) {
                if ($this->file) {
                    $this->file->saveAs(Yii::getAlias('@webroot') . "/uploads/{$user->image}");
                }

                $rbac->assign($userRole, $user->id);

                $transaction->commit();
                return $user;
            }
            else
            {
                $transaction->rollBack();
            }
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
        return null;
    }
}