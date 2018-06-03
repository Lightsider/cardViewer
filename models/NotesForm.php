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
class NotesForm extends Model
{
    public $text;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['text', 'trim'],
            ['text', 'required'],
            ['text', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Ваша заметка',
        ];
    }

    /*
     * @var app/models/User $user
     */
    public function sendNotes($user)
    {
        if(Yii::$app->user->isGuest)
            return false;

        $notes = new Notes();
        $oldNote=Notes::find()->where("id_user=".$user->id.
            " and id_owner=".Yii::$app->user->id)->one();
        if(!empty($oldNote))
            $notes=$oldNote;



        $notes->id_user=$user->id;
        $notes->id_owner=Yii::$app->user->id;
        $notes->text=$this->text;

        if($notes->save())
        {
            return true;
        }
        return false;

    }

}