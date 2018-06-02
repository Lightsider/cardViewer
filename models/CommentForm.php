<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;

/**
 * Register is the model behind the login form.
 * @var ContactForm $this
 * @property User|null $user This property is read-only.
 *
 */
class CommentForm extends Model
{
    public $text;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['text', 'trim'],
            ['text', 'required'],
            ['text', 'string', 'min' => 3],
            ['verifyCode', 'captcha','message' => " Неверный код с картинки "]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Ваш комментарий',
            'verifyCode' => 'Капча',
        ];
    }


    /*
     * @var app/models/Products $product
     */
    public function sendComment($product)
    {
        if(Yii::$app->user->isGuest)
            return false;

        $comment = new Comments();

        $comment->id_user=Yii::$app->user->id;
        $comment->id_product=$product->id;
        $comment->text=$this->text;
        $date = new DateTime('now',new \DateTimeZone("Asia/Barnaul"));
        $comment->datetime= $date->format("Y-m-d H-i-s");

        if($comment->save())
        {
            return true;
        }
        var_dump($comment);die();

        return false;

    }

}