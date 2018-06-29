<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Model;
use yii\db\Query;

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
        if (Yii::$app->user->isGuest)
            return false;

        $notes = new Notes();
        $oldNote = Notes::find()->where("id_user=" . $user->id .
            " and id_owner=" . Yii::$app->user->id)->one();
        if (!empty($oldNote))
            $notes = $oldNote;


        $notes->id_user = $user->id;
        $notes->id_owner = Yii::$app->user->id;
        $notes->text = $this->text;


        if (empty($oldNote)) {
            $query = Yii::$app->db->createCommand("INSERT INTO notes (id_owner,id_user,text) VALUES(:id_owner,:id_user,\"{$notes->text} \")", [
                ':id_owner' => $notes->id_owner,
                ':id_user' => $notes->id_user,
            ]);
        } else {
            $query = Yii::$app->db->createCommand("UPDATE notes SET id_owner=:id_owner, id_user=:id_user, text=\"{$notes->text} \" WHERE id={$oldNote->id}", [
                ':id_owner' => $notes->id_owner,
                ':id_user' => $notes->id_user,
            ]);
        }
        $notes->save();


        if ($query->execute()) {
            return true;
        }
        return false;

    }

}