<?php

use yii\db\Migration;

/**
 * Class m180529_062128_addContactsTable
 */
class m180529_062128_addReviewsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->createTable('reviews', [
                'id' => $this->primaryKey()->comment('Первичный ключ'),
                'name' => $this->string(255)->notNull(),
                'email' => $this->string(255)->notNull(),
                'message' => $this->text()->notNull(),
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->dropTable("reviews");

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180529_062128_addContactsTable cannot be reverted.\n";

        return false;
    }
    */
}
