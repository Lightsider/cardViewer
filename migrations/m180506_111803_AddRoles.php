<?php

use yii\db\Migration;

/**
 * Class m180506_111803_AddRoles
 */
class m180506_111803_AddRoles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rbac = \Yii::$app->authManager;
        $guest = $rbac->createRole('guest');
        $guest->description = 'Посетитель';
        $rbac->add($guest);
        $user = $rbac->createRole('user');
        $user->description = 'Участник';
        $rbac->add($user);
        $admin = $rbac->createRole('admin');
        $admin->description = 'Администратор';
        $rbac->add($admin);
        $rbac->addChild($admin, $user);
        $rbac->addChild($user, $guest);
        $rbac->assign(
            $admin,
            \app\models\Users::findOne([
                'login' => 'admin'])->id
        );
    }
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $manager = \Yii::$app->authManager;
        $manager->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180506_111803_AddRoles cannot be reverted.\n";

        return false;
    }
    */
}
