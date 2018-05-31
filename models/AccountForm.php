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
class AccountForm extends Model
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

            ['password', 'string', 'min' => 3],

            ['password_repeat', 'string', 'min' => 3],
            ['password_repeat', 'compare','compareAttribute'=>'password','message'=>'Пароли должны совпадать'],

            ['selfdescription', 'required'],
            ['selfdescription', 'string']
        ];
    }

    public function afterValidate() {
        $model = User::findIdentity(Yii::$app->user->id);
        if($model) {
            $errors = $this->getErrors();
            if(isset($errors['login']) && $this->attributes['login'] == $model->login)$this->clearErrors('login');
        }
        return parent::afterValidate();
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
    public function update()
    {
        $user = User::findIdentity(Yii::$app->user->id);

        if (!$this->validate()) {
            var_dump($this->getErrors());
            die();
            return null;
        }

        $user->id = Yii::$app->user->id;
        $user->login = $this->login;

        if($this->password!=="")
        $user->setPassword($this->password);

        if ($this->file) {
            $oldFile=$user->image;
            $user->image = \Yii::$app->security->generateRandomString() . '.jpg';
        } elseif(!isset($user->image)) $user->image = "/uploads/no_image.png";
        $user->selfdescription=$this->selfdescription;


        $transaction = Yii::$app->db->beginTransaction();
        try {

            if ($user->save()) {
                if ($this->file) {
                    unlink(Yii::getAlias('@webroot') . "/uploads/{$oldFile}");
                    $this->file->saveAs(Yii::getAlias('@webroot') . "/uploads/{$user->image}");
                }

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